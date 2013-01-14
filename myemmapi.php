<?php

	require_once 'Exception.php';
	
	/**
	 * MyEmma API Wrapper
	 *
	 * @category  Services
	 * @package   Services_Myemma
	 * @author    Dennis Monsewicz <dennismonsewicz@gmail.com>
	 * @copyright 2013 Dennis Monsewicz <dennismonsewicz@gmail.com>
	 * @license   http://www.opensource.org/licenses/mit-license.php MIT
	 * @link      https://github.com/myemma/emma-wrapper-php
	 */
	class Myemmapi {
		/**
		* Cache the API base url
		*/
		public $base_url = "https://api.e2ma.net/";
		/**
		* Cache the user account id for API usage
		*/
		private $_account_id;
		/**
		* Cache the user public key for API usage
		*/
		private $_pub_key;
		/**
		* Cache the user private key for API usage
		*/
		private $_priv_key;
		/**
		* Cache optional postdata for HTTP request
		*/
		public $_postData;
		
		/**
		* Connect to the Emma API
		* @param string $account_id		Your Emma Account Id
		* @param string $pub_api_key	Your Emma Public API Key
		* @param string $priv_api_key	Your Emma Public API Key
		* @access public
		*/
		function __construct($account_id, $pub_api_key, $pri_api_key) {
			if(empty($account_id))
				throw new Myemmapi_Missing_Account_Id();
			
			if(empty($pub_api_key) || empty($pri_api_key))
				throw new Myemmapi_Missing_Auth_For_Request();
			
			$this->_account_id = $account_id;
			$this->_pub_key = $pub_api_key;
			$this->_priv_key = $pri_api_key;
		}
		
		/**
		* Send a GET HTTP request
		* @param string $path		Optional post data
		* @param array $params		Optional query string parameters
		* @return array of information from API request
		* @access public
		*/
		function get($path, $params = array()) {
			$url = $this->_constructUrl($path, $params);
			
			return $this->_request($url);
		}
		
		/**
		* Send a POST HTTP request
		* @param string $path		Request path
		* @param array $postData	Optional post data
		* @return array of information from API request
		* @access public
		*/
		function post($path, $postData = array()) {
			$url = $this->_constructUrl($path);
			$this->_postData = $postData;
			return $this->_request($url, "post");
		}
		
		/**
		* Send a PUT HTTP request
		* @param string $path		Request path
		* @param array $postData	Optional post data
		* @return array of information from API request
		* @access public
		*/
		function put($path, $postData = array()) {
			$url = $this->_constructUrl($path);
			$this->_postData = $postData;
			return $this->_request($url, "put");
		}
		
		/**
		* Send a DELETE HTTP request
		* @param string $path		Request path
		* @param array $params		Optional query string parameters
		* @return array of information from API request
		* @access public
		*/
		function delete($path, $params = array()) {
			$url = $this->_constructUrl($path, $params);
			return $this->_request($url, "delete");
		}
		
		/**
		* Performs the actual HTTP request using cURL
		* @param string $url		Absolute URL to request
		* @param array $verb		Which type of HTTP Request to make
		* @return json encoded array of information from API request
		* @access private
		*/
		protected function _request($url, $verb = null) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_USERPWD, "{$this->_pub_key}:{$this->_priv_key}");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			if(isset($verb)) {
				if($verb == "post") {
					curl_setopt($ch, CURLOPT_POST, true);
				} else {
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($verb));
				}
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->_postData));
			}
			
			$data = curl_exec($ch);
			$info = curl_getinfo($ch);
			
			curl_close($ch);
			
			if($this->_validHttpResponseCode($info['http_code'])) {
				return $data;
			} else {
				throw new Myemmapi_Invalid_Response_Exception(null, 0, $data, $info['http_code']);
			}
		}
		
		/**
		* Performs the actual HTTP request using cURL
		* @param string $path		Relative or absolute URI
		* @param array $params		Optional query string parameters
		* @return string $url
		* @access private
		*/
		protected function _constructUrl($path, $params = array()) {
			$url = $this->base_url . $this->_account_id;
			$url .= $path;
			$url .= (count($params)) ? '?' . http_build_query($params) : '';
			
			return $url;
		}
		
		/**
		* Validate HTTP response code
		* @param integer $code 		HTTP code
		* @return boolean
		* @access private
		*/
		protected function _validHttpResponseCode($code) {
			return (bool)preg_match('/^20[0-9]{1}/', $code);
		}
	}
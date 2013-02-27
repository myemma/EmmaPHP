<?php

	/**
	 * Emma API Wrapper Exception for if there is a missing Account ID
	 *
	 * @category  Services
	 * @author    Dennis Monsewicz <dennismonsewicz@gmail.com>
	 * @copyright 2013 Dennis Monsewicz <dennismonsewicz@gmail.com>
	 * @license   http://www.opensource.org/licenses/mit-license.php MIT
	 * @link      https://github.com/myemma/emma-wrapper-php
	 */
	class Emma_Missing_Account_Id extends Exception {
		protected $message = "All requests must include your Account ID";
	}
	
	/**
	 * Emma API Wrapper Exception for if there is a missing public key or private key
	 *
	 * @category  Services
	 * @author    Dennis Monsewicz <dennismonsewicz@gmail.com>
	 * @copyright 2013 Dennis Monsewicz <dennismonsewicz@gmail.com>
	 * @license   http://www.opensource.org/licenses/mit-license.php MIT
	 * @link      https://github.com/myemma/emma-wrapper-php
	 */
	class Emma_Missing_Auth_For_Request extends Exception {
		protected $message = "All requests must include both your Public API Key and your Private API Key";
	}

	/**
	 * Emma API Wrapper Custom Exception
	 *
	 * @category  Services
	 * @author    Dennis Monsewicz <dennismonsewicz@gmail.com>
	 * @copyright 2013 Dennis Monsewicz <dennismonsewicz@gmail.com>
	 * @license   http://www.opensource.org/licenses/mit-license.php MIT
	 * @link      https://github.com/myemma/emma-wrapper-php
	 */

	class Emma_Invalid_Response_Exception extends Exception {
		/**
		* Default Message
		* @access protected
		* @var string
		*/
		protected $message = 'The requested URL responded with HTTP code %d';
		/**
		* HTTP Response Code
		* @access protected
		* @var integer
		*/
		protected $httpCode;
		/**
		* HTTP Response Body
		* @access protected
		* @var string
		*/
		protected $httpBody;
		/**
		* Constructor
		*
		* @param string $message
		* @param string $code
		* @param string $httpBody
		* @param integer $httpCode
		* @access protected
		* @var integer
		*/
		public function __construct($message = null, $code = 0, $httpBody, $httpCode = 0) {
			$this->httpBody = $httpBody;
			$this->httpCode = $httpCode;
			$message = sprintf($this->message, $httpCode);
			parent::__construct($message, $code);
		}
		/**
		* Get HTTP response body
		*/
		public function getHttpBody() {
			return $this->httpBody;
		}
		/**
		* Get HTTP response code
		*/
		public function getHttpCode() {
			return $this->httpCode;
		}
	}
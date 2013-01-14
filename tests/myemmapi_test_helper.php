<?php
	set_include_path(
	    get_include_path()
	    . PATH_SEPARATOR
	    . realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..')
	);

	require_once 'myemmapi.php';
	
	class Myemmapi_Expose extends Myemmapi {
		function __construct($account_id, $pub_key, $priv_key) {
			parent::__construct($account_id, $pub_key, $priv_key);
		}
		
		function validResponseCode($code) {
			return $this->_validResponseCode($code);
		}
		
		function buildUrl($url, $params = array()) {
			return $this->_buildUrl($url, $params);
		}
	}
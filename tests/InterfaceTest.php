<?php

	class TestInterface extends PHPUnit_Framework_TestCase {
		protected $account_id;
		protected $public_key;
		protected $private_key;
		protected $debug;
		
		public function setup() {
			$this->account_id = ACCOUNT_ID;
			$this->public_key = API_PUBLIC_KEY;
			$this->private_key = API_PRIVATE_KEY;
			$this->debug = true;
		}
		
		public function teardown() {
			unset($this->account_id);
			unset($this->public_key);
			unset($this->private_key);
			unset($this->debug);
		}
		
		public function testMissingAccountId() {
			$this->setExpectedException('Emma_Missing_Account_Id');
			$this->em = new Emma('', $this->public_key, $this->private_key);
		}
		
		public function testMissingPublicKey() {
			$this->setExpectedException('Emma_Missing_Auth_For_Request');
			$this->em = new Emma($this->account_id, '', $this->private_key);
		}
		
		public function testMissingPrivateKey() {
			$this->setExpectedException('Emma_Missing_Auth_For_Request');
			$this->em = new Emma($this->account_id, $this->public_key, '');
		}
	}
<?php
	require_once "myemmapi_test_helper.php";
	
	class Myemmapitest extends PHPUnit_Framework_TestCase {
		protected $my;
		
		public function setUp() {
			$this->my = new Myemmapi_Expose('1718788', 'f8d4b115292e8aa25356', '615ea1e36e9470c7746d');
		}
		
		public function teardown() {
			unset($this->my);
		}
		
		public function testResponseCodeSuccess() {
			self::assertTrue($this->my->validResponseCode(200));
		}
		
		public function testResponseCodeServerError() {
			self::assertFalse($this->my->validResponseCode(500));
		}
		
		public function testResponseCodeClientError() {
			self::assertFalse($this->my->validResponseCode(400));
		}
		
		public function testBuildUrl() {
			self::assertEquals(
				'https://api.e2ma.net/1718788/groups',
				$this->my->buildUrl('/groups')
			);
		}
		
		public function testBuildUrlWithQueryParams() {
			self::assertEquals(
				'https://api.e2ma.net/1718788/groups?group_types=g',
				$this->my->buildUrl('/groups', array('group_types' => 'g'))
			);
		}
		
		public function testMissingAccountId() {
			$this->setExpectedException('Myemmapi_Missing_Account_Id');
			$api = new Myemmapi('', 'f8d4b115292e8aa25356', '615ea1e36e9470c7746d');
		}
		
		public function testMissingPublicKey() {
			$this->setExpectedException('Myemmapi_Missing_Auth_For_Request');
			$api = new Myemmapi('1718788', '', '615ea1e36e9470c7746d');
		}
		
		public function testMissingPrivateKey() {
			$this->setExpectedException('Myemmapi_Missing_Auth_For_Request');
			$api = new Myemmapi('1718788', 'f8d4b115292e8aa25356', '');
		}
	}
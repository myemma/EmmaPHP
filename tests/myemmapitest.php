<?php
	require_once "myemmapi_test_helper.php";
	
	class Myemmapitest extends PHPUnit_Framework_TestCase {
		protected $my;
		
		public function setUp() {
			$this->my = new Emmapi_Test_Helper('1718788', 'f8d4b115292e8aa25356', '615ea1e36e9470c7746d');
		}
		
		public function teardown() {
			unset($this->my);
		}
		
		public function testResponseCodeSuccess() {
			$this->assertTrue($this->my->validHttpResponseCode(200));
		}
		
		public function testResponseCodeServerError() {
			$this->assertFalse($this->my->validHttpResponseCode(500));
		}
		
		public function testResponseCodeClientError() {
			$this->assertFalse($this->my->validHttpResponseCode(400));
		}
		
		public function testBuildUrl() {
			$this->assertEquals(
				'https://api.e2ma.net/1718788/groups',
				$this->my->constructUrl('/groups')
			);
		}
		
		public function testBuildUrlWithQueryParams() {
			$this->assertEquals(
				'https://api.e2ma.net/1718788/groups?group_types=g',
				$this->my->constructUrl('/groups', array('group_types' => 'g'))
			);
		}
		
		public function testMissingAccountId() {
			$this->setExpectedException('Myemmapi_Missing_Account_Id');
			$api = new Emmapi('', 'f8d4b115292e8aa25356', '615ea1e36e9470c7746d');
		}
		
		public function testMissingPublicKey() {
			$this->setExpectedException('Myemmapi_Missing_Auth_For_Request');
			$api = new Emmapi('1718788', '', '615ea1e36e9470c7746d');
		}
		
		public function testMissingPrivateKey() {
			$this->setExpectedException('Myemmapi_Missing_Auth_For_Request');
			$api = new Emmapi('1718788', 'f8d4b115292e8aa25356', '');
		}
	}
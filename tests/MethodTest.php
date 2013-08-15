<?php

	class TestMethods extends PHPUnit_Framework_TestCase {
		protected $account_id;
		protected $public_key;
		protected $private_key;
		protected $debug;
		protected $em;
		
		public function setup() {
			$this->account_id = ACCOUNT_ID;
			$this->public_key = API_PUBLIC_KEY;
			$this->private_key = API_PRIVATE_KEY;
			$this->debug = false;
			$this->em = new Emma($this->account_id, $this->public_key, $this->private_key, $this->debug);
		}
		
		public function testmyMembers() {
			$req = json_decode($this->em->myMembers());
			$this->assertInternalType('array', $req);
		}
		
		public function testmembersListById() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersListById(111));
		}
		
		public function testmembersListByEmail() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersListByEmail('test123@gmail.com'));
		}
		
		public function testmembersListOptout() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersListByEmail(111));
		}
		
		public function testmembersOptout() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersOptout('test123@gmail.com'));
		}
		
		public function testmembersBatchAdd() {
			$rand = $this->_generateRandomString();
			$rand2 = $this->_generateRandomString();
			$members['members'] = array();
			$members['email'] = array();
			$members['email'][0]['email'] = 'dennismonsewicz+' . $rand . '@gmail.com';
			$members['email'][1]['email'] = 'dennismonsewicz+' . $rand2 . '@gmail.com';
			$req = json_decode($this->em->membersBatchAdd($members));
			$this->assertSelectRegExp('import_id', '/import_id/', false, $req);
		}
		
		public function testmembersAddSingle() {
			$rand = $this->_generateRandomString();
			$member = array();
			$member['email'] = 'dennismonsewicz+' . $rand .'@gmail.com';
			$member['fields'] = array('first_name' => 'Hola');
			$req = json_decode($this->em->membersAddSingle($member));
			$this->assertSelectRegExp('member_id', '/member_id/', false, $req);
		}
		
		public function testmembersSignup() {
			$rand = $this->_generateRandomString();
			$member = array();
			$member['email'] = 'dennismonsewicz+' . $rand .'@gmail.com';
			$member['fields'] = array('first_name' => 'Hola');
			$member['group_ids'] = array(1223);
			$req = json_decode($this->em->membersSignup($member));
			$this->assertSelectRegExp('member_id', '/member_id/', false, $req);
		}
		
		public function testmembersRemove() {
			$members = array('member_ids' => array(101, 102));
			$req = json_decode($this->em->membersRemove($members));
			$this->assertTrue($req);
		}
		
		public function testmembersChangeStatus() {
			$members = array('member_ids' => array(101, 102), 'status_to' => 'a');
			$req = json_decode($this->em->membersChangeStatus($members));
			$this->assertTrue($req);
		}
		
		public function testmembersUpdateSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersUpdateSingle(111));
		}
		
		public function testmembersRemoveSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersRemoveSingle(111));
		}
		
		public function testmembersListSingleGroups() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersListSingleGroups(111));
		}
		
		public function testmembersGroupsAdd() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersListSingleGroups(111, array('group_ids' => array(1,2))));
		}
		
		public function testmembersRemoveSingleFromGroups() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersListSingleGroups(111, array('group_ids' => array(1223))));
		}
		
		public function testmembersRemoveAll() {
			$req = json_decode($this->em->membersRemoveAll('a'));
			$this->assertTrue($req);
		}
		
		public function testmembersRemoveFromAllGroups() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersRemoveFromAllGroups(111));
		}
		
		public function testmembersRemoveMultipleFromGroups() {
			$req = json_decode($this->em->membersRemoveMultipleFromGroups(array('group_ids' => 111, 'member_ids' => 111)));
			$this->assertFalse($req);
		}
		
		public function testmembersMailingHistory() {
			$req = json_decode($this->em->membersMailingHistory(111));
			$this->assertInternalType('array', $req);
		}
		
		public function testmembersImported() {
			$req = json_decode($this->em->membersImported(111));
			$this->assertInternalType('array', $req);
		}
		
		public function testmyImports() {
			$req = json_decode($this->em->myImports());
			$this->assertInternalType('array', $req);
		}
		
		public function testmembersRemoveImport() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersRemoveImport(111));
		}
		
		public function testmembersCopyToGroup() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->membersCopyToGroup(111, array('member_status_id' => array('a'))));
		}
		
		public function testmembersUpdateGroupMembersStatus() {
			$req = json_decode($this->em->membersUpdateGroupMembersStatus('e', 'a', 111));
			$this->assertTrue($req);
		}
		
		public function testmyFields() {
			$req = json_decode($this->em->myFields());
			$this->assertInternalType('array', $req);
		}
		
		public function testfieldsGetById() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->fieldsGetById(111));
		}
		
		public function testfieldsAddSingle() {
			$field = array();
			$field['shortcut_name'] = 'new_field_' . $this->_generateRandomString();
			$field['column_order'] = 1;
			$field['display_name'] = 'A New Field';
			$field['field_type'] = 'text';
			$req = json_decode($this->em->fieldsAddSingle($field));
			$this->assertInternalType('integer', $req);
		}
		
		public function testfieldsRemove() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->fieldsRemoveSingle(111));
		}
		
		public function testfieldsRemoveMemberDataForField() {
			$req = json_decode($this->em->fieldsRemoveMemberDataForField(111));
			$this->assertTrue($req);
		}
		
		public function testfieldsUpdateSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$field = array();
			$field['display_name'] = "Your First Name";
			$req = json_decode($this->em->fieldsUpdateSingle(111, $field));
		}
		
		public function testmyGroups() {
			$req = json_decode($this->em->myGroups());
			$this->assertInternalType('array', $req);
		}
		
		public function testgroupsAdd() {
			$groups = array();
			$groups['groups'] = array();
			$groups['groups'][0]['group_name'] = "My Group Here";
			$req = json_decode($this->em->groupsAdd($groups));
			$this->assertSelectRegExp('member_group_id', '/member_group_id/', false, $req);
		}
		
		public function testgroupsGetById() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->groupsGetById(111));
		}
		
		public function testgroupsUpdateSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$g = array();
			$g['group_name'] = 'A new name goes here';
			$req = json_decode($this->em->groupsUpdateSingle(111, $g));
		}
		
		public function testgroupsRemoveSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->groupsRemoveSingle(111));
		}
		
		public function testgroupsGetMembers() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->groupsGetMembers(111));
		}
		
		public function testgroupsAddMembersToGroup() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$ids[] = 1;
			$req = json_decode($this->em->groupsAddMembersToGroup(111, $ids));
		}
		
		public function testgroupsRemoveMembers() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$ids[] = 1;
			$ids[] = 2;
			$req = json_decode($this->em->groupsRemoveMembers(111, $ids));
		}
		
		public function testgroupsRemoveAllMembersAsBackgroundJob() {
			$req = json_decode($this->em->groupsRemoveAllMembersAsBackgroundJob(111));
			$this->assertTrue($req);
		}
		
		public function testgroupsCopyMembers() {
			$req = json_decode($this->em->groupsCopyMembers(111, 112, array('member_status_id' => array('a'))));
			$this->assertTrue($req);
		}
		
		public function testmyMailings() {
			$req = json_decode($this->em->myMailings());
			$this->assertInternalType('array', $req);
		}
		
		public function testmailingsGetById() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsGetById(111));
		}
		
		public function testmailingsPersonalizedMemberMailing() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsPersonalizedMemberMailing(111, 12));
		}
		
		public function testmailingsMembersById() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsMembersById(111));
		}
		
		public function testmailingsGetGroups() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsGetGroups(111));
		}
		
		public function testmailingsSearches() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsSearches(111));
		}
		
		public function testmailingsUpdateSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsUpdateSingle(111, array('status' => 'canceled')));
		}
		
		public function testmailingsRemoveSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsRemoveSingle(111));
		}
		
		public function testmailingsCanceledQueued() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsCanceledQueued(111));
		}
		
		public function testmailingsForward() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsForward(111, 102, array('recipient_emails' => array('test123@gmail.com'))));
		}
		
		public function testmailingsSendExisting() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsSendExisting(111, array('recipient_emails' => array('test123@gmail.com'))));
		}
		
		public function testmailingsHeadsup() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsHeadsup(111));
		}
		
		public function testmailingsValidate() {
			$req = json_decode($this->em->mailingsValidate(array('subject' => 'Another Test')));
			$this->assertTrue($req);
		}
		
		public function testmailingsDeclareWinnerOfSplitTest() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->mailingsDeclareWinnerOfSplitTest(111, 102));
		}
		
		public function testmyAccountSummary() {
			$req = json_decode($this->em->myAccountSummary());
			$this->assertInternalType('array', $req);
		}
		
		public function testresponseSingleSummary() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->responseSingleSummary(111));
		}
		
		public function testresponseMailingInformation() {
			$responses[] = 'sends';
			$responses[] = 'in_progress';
			$responses[] = 'deliveries';
			$responses[] = 'opens';
			$responses[] = 'links';
			$responses[] = 'clicks';
			$responses[] = 'forwards';
			$responses[] = 'optouts';
			$responses[] = 'signups';
			$responses[] = 'shares';
			$responses[] = 'customer_shares';
			$responses[] = 'customer_share_clicks';
			
			foreach($responses as $resp) {
				$this->setExpectedException('Emma_Invalid_Response_Exception');
				$req = json_decode($this->em->responseMailingInformation(111, $resp));
			}
			
		}
		
		public function testresponseCustomerShareInformation() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->responseSingleSummary(111));
		}
		
		public function testresponseSharesOverview() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->responseSharesOverview(111));
		}
		
		public function testmySearches() {
			$req = json_decode($this->em->mySearches());
			$this->assertInternalType('array', $req);
		}
		
		public function testsearchesGetById() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->searchesGetById(121));
		}
		
		public function testsearchesCreateSingle() {
			$search = array('name' => 'new search 2', 'criteria' => array('or', array('group', 'eq', 'Monthly Newsletter')));
			$req = json_decode($this->em->searchesCreateSingle($search));
			$this->assertInternalType('integer', $req);
		}
		
		public function testsearchesUpdateSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$search = array('name' => 'new search 2', 'criteria' => array('or', array('group', 'eq', 'Monthly Newsletter')));
			$req = json_decode($this->em->searchesUpdateSingle(111, $search));
		}
		
		public function testsearchesRemoveSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->searchesRemoveSingle(121));
		}
		
		public function testsearchesMembers() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->searchesMembers(121));
		}
		
		public function testmyTriggers() {
			$req = json_decode($this->em->myTriggers());
			$this->assertInternalType('array', $req);
		}
		
		public function testtriggersCreate() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->triggersCreate(array('parent_mailing_id' => 111, 'name' => 'test', 'event_type' => 'c', 'object_ids' => array(101, 102))));
		}
		
		public function testtriggersGetSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->triggersGetSingle(121));
		}
		
		public function testtriggersUpdateSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->triggersUpdateSingle(121, array('name' => 'Another testing is being done')));
		}
		
		public function testtriggersRemoveSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->triggersUpdateSingle(121));
		}
		
		public function testtriggersMailings() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->triggersMailings(121));
		}
		
		public function testmyWebhooks() {
			$req = json_decode($this->em->myWebhooks());
			$this->assertInternalType('array', $req);
		}
		
		public function testwebhooksGetSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->webhooksGetSingle(121));
		}
		
		public function testwebhooksGetEvents() {
			$req = json_decode($this->em->webhooksGetEvents());
			$this->assertInternalType('array', $req);
		}
		
		public function testwebhooksCreate() {
			$req = json_decode($this->em->webhooksCreate(array('url' => 'http://www.google.com', 'event' => 'mailing_finish')));
			$this->assertInternalType('integer', $req);
		}
		
		public function testwebhooksRemoveSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->webhooksRemoveSingle(111));
		}
		
		public function testwebhooksUpdateSingle() {
			$this->setExpectedException('Emma_Invalid_Response_Exception');
			$req = json_decode($this->em->webhooksUpdateSingle(111, array('url' => 'http://www.google.com', 'event' => 'mailing_finish')));
		}
		
		public function testwebhooksRemoveAll() {
			$req = json_decode($this->em->webhooksRemoveAll());
			$this->assertTrue($req);
		}
		
		private function _generateRandomString($length = 10) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
			    $randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}
	}
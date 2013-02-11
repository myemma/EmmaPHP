##emma-wrapper-php

A PHP wrapper for Emma's API.

## Examples
Wrapper includes methods to help with performing HTTP requests to Emma's public API

## Running the tests

`phpunit --bootstrap tests/Bootstrap.php tests`

## Instantiation
```php
require 'emmapi.php';
$em = new Emmapi('account_id', 'public_key', 'private_key', debug_true_or_false);
```

## GET Request
```php
// Returns an array of all members
$req = $em->myMembers();
echo json_decode($req);
```

## Pagination
```php
// Returns a count of all members
$req = $em->myMembers(array('count' => true));
echo json_decode($req);
```

```php
// Returns an array of members with specific offset
$req = $em->myMembers(array('start' => 5, 'end' => 75));
echo json_decode($req);
```

## POST Request
```php
// Returns The member_id of the new or updated member, whether the member was added or an existing member was updated, and the status of the member. The status will be reported as ‘a’ (active), ‘e’ (error), or ‘o’ (optout).
try {
	$member = array();
	$member['email'] = 'testing123@gmail.com';
	$member['fields'] = array('first_name' => 'bob', 'last_name' => 'saget');
	$req = $em->membersAddSingle($member);
	echo json_decode($req);
} catch(Emmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage());
}

```

## PUT Request
```php
// Returns True if the member was updated successfully
try {
	$member = array();
	$member['email'] = 'testing345@gmail.com';
	$member['fields'] = array('first_name' => 'Betty', 'last_name' => 'Sue');
	$member['status_to'] = 'a';
	$req = $em->membersUpdateSingle(111, $member);
	echo json_decode($req);
} catch(Emmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage());
}
```

## DELETE Request
```php
// Returns True if the member is deleted.
try {
	$req = $em->membersRemoveSingle(111);
	echo json_decode($req);
} catch(Emmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage());
}
```
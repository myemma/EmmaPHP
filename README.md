##Emma API Wrapper (PHP)

A PHP wrapper for Emma's API.

## Running the tests [![Build Status](https://travis-ci.org/myemma/emma-wrapper-php.png)](https://travis-ci.org/myemma/emma-wrapper-php)
Update tests/Bootstrap.php with your account id and api keys.

`phpunit --bootstrap tests/Bootstrap.php tests`

## Examples
Wrapper includes methods to help with performing HTTP requests to Emma's public API

## Instantiation
```php
require 'src/Emma.php';
$account_id = 123456; // Replace with your account id
$public_key = 'ec6936852ca7a4136fdc'; // Replace with your public key
$private_key = '63bfa55a2b5e3554db4c'; // Replace with your private key
$emma = new Emma($account_id, $public_key, $private_key);
```

## GET Request
```php
// Returns an array of all members
$req = $emma->myMembers();
echo json_decode($req);
```

## Pagination
```php
// Returns a count of all members
$req = $emma->myMembers(array('count' => true));
echo json_decode($req);
```

```php
// Returns an array of members with specific offset
$req = $emma->myMembers(array('start' => 5, 'end' => 75));
echo json_decode($req);
```

## POST Request
```php
// Returns The member_id of the new or updated member, whether the member was added or an existing member was updated, and the status of the member. The status will be reported as ‘a’ (active), ‘e’ (error), or ‘o’ (optout).
try {
	$member = array();
	$member['email'] = 'testing123@gmail.com';
	$member['fields'] = array('first_name' => 'bob', 'last_name' => 'saget');
	$req = $emma->membersAddSingle($member);
	echo json_decode($req);
} catch(Emma_Invalid_Response_Exception $e) {
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
	$req = $emma->membersUpdateSingle(111, $member);
	echo json_decode($req);
} catch(Emma_Invalid_Response_Exception $e) {
	exit($e->getMessage());
}
```

## DELETE Request
```php
// Returns True if the member is deleted.
try {
	$req = $emma->membersRemoveSingle(111);
	echo json_decode($req);
} catch(Emma_Invalid_Response_Exception $e) {
	exit($e->getMessage());
}
```
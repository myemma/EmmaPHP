emma-wrapper-php
================

A PHP wrapper for Emma's API.

### Examples
Wrapper includes methods to help with performing HTTP requests to MyEmma's public API

### Instantiate Myemma API Class
``` php
<?php
$em = new Myemmapi("xxx", "xxx", "xxx");
```
### GET
``` php
<?php
try {
	$resp = json_decode($em->get('/members'));
	echo $resp;
} catch (Myemmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage() . "\n");
}
```

### POST
``` php
<?php
try {
	$data = array(
		"email" => "test123@example.com",
		"fields" => array(
			"first_name" => "Test",
			"last_name" => "Tester"
		),
		"group_ids" => array(123456)
	);
	$resp = json_decode($em->post('/members/add', $data));
	echo $resp;
} catch (Myemmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage() . "\n");
}
```
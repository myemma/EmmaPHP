emma-wrapper-php
---

A PHP wrapper for Emma's API.
---

### Examples
---
Wrapper includes methods to help with performing HTTP requests to MyEmma's public API

### Instantiate Myemma API Class
---
``` php
<?php
$em = new Myemmapi("xxx", "xxx", "xxx");
```

### GET
---
``` php
<?php
try {
	$resp = json_decode($em->get('/members'), true);
	var_dump($resp);
} catch (Myemmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage() . "\n");
}
```

### POST
---
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
	$resp = json_decode($em->post('/members/add', $data), true);
	var_dump($resp);
} catch (Myemmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage() . "\n");
}
```

### PUT
---
``` php
<?php
try {
	$data = array(
		"fields" => array(
			"first_name" => "Test",
			"last_name" => "Tester"
		),
		"email" => "test123@example.com",
		"status_to" => "a"
	);
	$resp = json_decode($em->put('/members/12345', $data), true);
	var_dump($resp);
} catch (Myemmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage() . "\n");
}
```

### DELETE
---
``` php
<?php
try {
	$resp = json_decode($em->delete('/members/12345'), true);
	var_dump($resp);
} catch (Myemmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage() . "\n");
}
```
emma-wrapper-php
================

A PHP wrapper for Emma's API.

### Examples
Wrapper includes methods to help with performing HTTP requests to MyEmma's public API

### Setup
``` php
<?php
$em = new Myemmapi("xxx", "xxx", "xxx");
```
### Get
``` php
<?php
try {
	$resp = json_decode($em->get('/members'));
	echo $resp;
} catch (Myemmapi_Invalid_Response_Exception $e) {
	exit($e->getMessage() . "\n");
}
```
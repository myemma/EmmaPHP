emma-wrapper-php
================

A PHP wrapper for Emma's API.

### Examples
Wrapper includes methods to help with performing HTTP requests to MyEmma's public API
### Get
```php
	<?php
		try {
			$em = new Myemmapi("xxx", "xxx", "xxx");
			$resp = json_decode($em->get('/members'));
			echo $resp;
		} catch (Myemmapi_Invalid_Response_Exception $e) {
			exit($e->getMessage() . "\n");
		}
```
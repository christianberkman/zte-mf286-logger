<?php
/**
 * ZTE MF286 Data Usage Logger
 * 2022 by Christian Berkman
 * 
 * index.php file
 */

 require_once( __DIR__ .'/../vendor/autoload.php');

 // Connect API
use ZTEMF286\Api;
$settings = require_once(__DIR__ .'/../settings.php');
$zteApi = new Api($credentials['ip'], $credentials['cookiePath']);
$login = $zteApi->login($credentials['password']);
unset($credentials);

// Login unsuccessful
if(!$login) exit('Login failed, check credentials');
print_r($zteApi->dataUsage());
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
$credentials = require_once(__DIR__ .'/../credentials.php');
$zteApi = new Api($credentials['ip']);
$login = $zteApi->login($credentials['password']);
unset($credentials);

// Login unsuccessful
if(!$login) exit('Login failed, check credentials');
 
// Switch page
switch($_GET['page']){
    default: 
        require_once( __DIR__ .'/home.php');
    break;
}

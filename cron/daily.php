<?php
/**
 * ZTE MF286 Data Usage Logger
 * 2022 by Christian Berkman
 * 
 * Daily Cronjob
*/

require_once( __DIR__ .'../../vendor/autoload.php');

// Connect API
use ZTEMF286\Api;
$credentials = require_once(__DIR__ .'/../credentials.php');
$zteApi = new Api($credentials['ip']);
$login = $zteApi->login($credentials['password']);
unset($credentials);

// Login unsuccessful
if(!$login) exit('Login failed, check credentials');
 
// Get usage, exit on failure
$usage = $zteApi->dataUsage();
if($usage == false) exit('Could not get data usage' . PHP_EOL);

// Compole New CSV Line
$dateTime = date('Y-m-d');
$columns = [
    $dateTime,
    $usage['rx']['GiB'],
    $usage['tx']['GiB'],
    $usage['total']['GiB']
];
$newLine = implode(',', $columns) . PHP_EOL;

// Append to CSV file
$csvFile = __DIR__ .'/../logs/daily.csv';
$fh = fopen($csvFile, 'a');
fwrite($fh, $newLine);
fclose($fh);
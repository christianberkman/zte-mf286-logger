<?php
/**
 * ZTE MF286 Data Usage Logger
 * 2022 by Christian Berkman
 * 
 * Hourly cronjob
*/

require_once( __DIR__ .'/../vendor/autoload.php');
require_once __DIR__ .'/../csv.php';

// Connect API
use ZTEMF286\Api;
$settings = require_once(__DIR__ .'/../settings.php');
$zteApi = new Api($settings['ip'], $settings['cookiePath']);
$login = $zteApi->login($settings['password']);

// Login unsuccessful
if(!$login) exit('Login failed, check settings');
 
// Get usage, exit on failure
$date = date('Y-m-d');
$dateTime = date('Y-m-d H:i');
$usage = $zteApi->dataUsage();
if($usage == false) exit('Could not get data usage' . PHP_EOL);

// Open CSV file
$csv = new Logger\Csv( fopen($settings['logPath'] ."/hourly-{$date}.csv", 'a+') );
$lastLine = $csv->lastLine();

// Calculate delta (in MiB)
if(!is_null($lastLine)){
    $lastDate = strtotime($lastLine[0]);
    $lastTotal = $lastLine[3];
    $dateDelta = (strtotime($dateTime) - $lastDate) / (3600);
    if($dateDelta != 0){
        $totalDelta = ($usage['total']['GiB'] - $lastTotal) * 1024;
        $delta = round( ($totalDelta / $dateDelta), 0);
    } else $delta = 0;
} else $delta = 0;

// Compole New CSV Line
$columns = [
    $dateTime,
    $usage['rx']['GiB'],
    $usage['tx']['GiB'],
    $usage['total']['GiB'],
    ($delta ?? 0)
];

// Append to CSV file
$write = $csv->appendLine($columns);
$csv->close();

if($write) exit("[{$dateTime}] rx: {$usage['rx']['GiB']} GiB, tx: {$usage['tx']['GiB']}, total: {$usage['total']['GiB']}, delta: {$delta} MiB". PHP_EOL);
else exit("Error writing to CSV: {$csv->file}". PHP_EOL);

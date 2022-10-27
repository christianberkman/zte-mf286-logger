<?php
/**
 * ZTE MF286 Data Usage Logger
 * 2022 by Christian Berkman
 * 
 * MakeJSON
 */

// Find hourly log files
$settings = require_once(__DIR__ .'/../settings.php');
$realpath = realpath($settings['logPath']);
$paths = glob( "{$realpath}/hourly-*.csv"); // will return full paths
$files = [];
foreach($paths as $path){
    $files[] = str_replace(["{$realpath}/hourly-", '.csv'], '', $path); // extract date only
}

// Sort array
krsort($files);
$files = array_values($files);

// Output
header('Content-Type: application/json; charset=utf-8');
echo json_encode($files, JSON_PRETTY_PRINT);
exit();

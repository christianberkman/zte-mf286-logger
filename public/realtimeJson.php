<?php
/**
 * ZTE MF286 Data Usage Logger
 * 2022 by Christian Berkman
 * 
 * Realtime Json
 */

require_once(__DIR__ .'/../vendor/autoload.php');

// Connect API
use ZTEMF286\Api;
$settings = require_once(__DIR__ .'/../settings.php');
$zteApi = new Api($settings['ip'], $settings['cookiePath']);
$login = $zteApi->login($settings['password']);

// Get realtime data
$realtime = $zteApi->realtime();
$usage = $zteApi->dataUsage();

$json = [
    'realtime' => $realtime,
    'usage' => $usage
];

// Output
header('Content-Type: application/json; charset=utf-8');
echo json_encode($json, JSON_PRETTY_PRINT);
exit();



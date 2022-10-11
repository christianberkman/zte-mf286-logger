<?php
/**
 * ZTE MF286 Data Usage Logger
 * 2022 by Christian Berkman
 * 
 * MakeJSON
 */

require_once( __DIR__ .'/../vendor/autoload.php');
require_once( __DIR__ .'/../classes/autoload.php');
$settings = require_once( __DIR__ .'/../settings.php' );

// CSV file
switch( ($_GET['file'] ??  null) ){
     case 'daily':
        $csvFile = 'daily.csv';
    break;

    case 'hourly':
        $date = $_GET['date'] ?? null;
        if(empty($date)) exit();
        $csvFile = 'hourly-'. $date .'.csv';
    break;

    default:
        exit();
    break;
}

// Column
switch(($_GET['column'] ?? null)){
    case 'rx': $col = 1; break;
    case 'tx': $col = 2; break;
    case 'delta': $col = 4; break;

    default:
    case 'total': $col = 3; break;
}

// Read CSV records
$csv = new Logger\Csv($settings['logPath'], $csvFile);
$records = $csv->records();
$csv->close();

// Create JSON array
$json = [];
foreach($records as $record){
    $json[] = [
        'x' => $record[0],
        'y' => ($record[$col] ?? 0)
    ];
}

// Output
header('Content-Type: application/json; charset=utf-8');
echo json_encode($json, JSON_PRETTY_PRINT);
exit();
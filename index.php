<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Facade\Data;

/**
 * Web API
 * Parameters: sourceId (String), limit (String), year (String
 * Return JSON with results.
 * Example: /index.php?sourceId=space&limit=1&year=2014
 */
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    try {
        $data = Data::getResult([
            'sourceId' => $_GET['sourceId'],
            'year' => (int) $_GET['year'],
            'limit' => (int) $_GET['limit']
        ]);
        echo json_encode($data);
    } catch (\Exception $e){
        throw $e;
    }
}

/**
 * Web API POST
 * Parameters: sourceId (String), limit (String), year (String
 * Return JSON with results.
 * Example: /index.php?sourceId=space&limit=1&year=2014
 */
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $body = json_decode(file_get_contents('php://input'), true);
    try {
        $data = Data::getResult([
            'sourceId' => $body['sourceId'],
            'year' => $body['year'],
            'limit' => $body['limit']
        ]);
        echo json_encode($data);
    } catch (\Exception $e){
        throw $e;
    }
}

/**
 * PHP-CLI API
 * Parameters: sourceId (String), limit (String), year (String
 * Return JSON with results.
 * Example: php index.php comics 2017 2
 */
if(php_sapi_name() == 'cli')
{
    try {
        $data = Data::getResult([
            'sourceId' => $argv[1],
            'year' => (int) $argv[2],
            'limit' => (int) $argv[3]
        ]);
        echo json_encode($data);
    } catch (\Exception $e){
        throw $e;
    }
}
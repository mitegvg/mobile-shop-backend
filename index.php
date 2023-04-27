<?php
require "./bootstrap.php";
use Src\Controller\DevicesController;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /devices
// everything else results in a 404 Not Found
/*
if ($uri[1] !== 'devices') {
    header("HTTP/1.1 404 Not Found");
    exit();
}
*/

$requestMethod = $_SERVER["REQUEST_METHOD"];
    // Access-Control headers are received during OPTIONS requests

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
        return 0;    
     }    
// pass the request method to the device controller and process the HTTP request:
$controller = new DevicesController($dbConnection, $requestMethod);
$controller->processRequest();
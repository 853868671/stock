
<?php

ini_set("display_errors", "on");
error_reporting(E_ALL);

include_once "vendor/autoload.php";

use Tiger\tigerRequest;

$tiger = new tigerRequest('cGZ5DJuRFNJ46kLKg59SADyWWPHDQBrGN8aYhDCh');

$tiger->getOrdersShow();
tigerRequest::test();
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use App\Container;
use App\Format\JSON;
use App\Format\XML;
use App\Kernel;

$data = [
    "Name" => "Cesar",
    "LastName" => "Lopez"
];

$kernel = new Kernel();
$kernel->boot();
$kernel->handleRequests();


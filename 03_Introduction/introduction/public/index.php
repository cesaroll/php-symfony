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

print("<html><pre>");

$kernel = new Kernel();
$kernel->boot();

$container = $kernel->getContainer();

$controller = $container->getService('App\\Controller\\IndexController');
var_dump($container->getServices());

var_dump($controller->index());

var_dump($container->getService('App\Controller\PostController')->index());

print("</pre></html>");

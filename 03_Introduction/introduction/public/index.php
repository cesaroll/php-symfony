<?php

require dirname(__DIR__).'/vendor/autoload.php';

use App\Container;
use App\Controller\IndexController;
use App\Format\BaseFormatInterface;
use App\Format\{FormatFactory, JSON, XML,YAML};
use App\Service\Serializer;

$data = [
    "Name" => "Cesar",
    "LastName" => "Lopez"
];

print("<html><pre>");

$container = new Container();
$container->addService('format.json', function() {
    return new JSON();    
});

$container->addService('format.xml', function() {
    return new XML();    
});

$container->addService('format', function() use ($container) {
    return $container->getService('format.json');
}, BaseFormatInterface::class);

$container->loadServices('App\\Service');
$container->loadServices('App\\Controller');


//var_dump($container);

$controller = $container->getService('App\\Controller\\IndexController');
var_dump($container->getServices());

var_dump($controller->index());

var_dump($container->getService('App\Controller\PostController')->index());

print("</pre></html>");

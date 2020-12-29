<?php

require dirname(__DIR__).'/vendor/autoload.php';

use App\Format\BaseFormatInterface;
use App\Format\{FormatFactory, JSON,XML,YAML};

$data = [
    "Name" => "Cesar",
    "LastName" => "Lopez"
];

$factory = new FormatFactory();
$format = $factory->getFormatter('JSON', $data);

print("<html><pre>");

var_dump($format->getName());
var_dump((string)$format);

print("</pre></html>");

<?php

require dirname(__DIR__).'/vendor/autoload.php';

use App\Format\BaseFormatInterface;
use App\Format\{FormatFactory, JSON, Serializer, XML,YAML};

$data = [
    "Name" => "Cesar",
    "LastName" => "Lopez"
];

print("<html><pre>");

$serializer = new Serializer(new JSON());
var_dump($serializer->serialize($data));

$serializer = new Serializer(new XML());
var_dump($serializer->serialize($data));


print("</pre></html>");

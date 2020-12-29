<?php

require dirname(__DIR__).'/vendor/autoload.php';

use App\Format\BaseFormatInterface;
use App\Format\{JSON,XML,YAML};


function convertData(BaseFormatInterface $format): string {
    return (string)$format;
}

function getName(BaseFormatInterface $format): string {
    return $format->getName();
}



$myInfo = [
    "Name" => "Cesar",
    "LastName" => "Lopez"
];

$json = new JSON($myInfo);
$xml = new XML($myInfo);
$yml = new YAML($myInfo);

print("<html><pre>");

$formats = [$json, $xml, $yml];

foreach($formats as $format) {
    var_dump(getName($format));
    var_dump(convertData($format));
}

print("</pre></html>");

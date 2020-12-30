<?php

/**
* @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
* @copyright 2020 Wayfair LLC - All rights reserved
*/
declare(strict_types=1);

namespace App\Format;

class FormatFactory {

    private array $formatters = [];

    public function __construct()
    {
        $this->formatters = [
            new JSON(),
            new XML(),
            new YAML()
        ];
    }

    public function getFormatter(string $name, array $data): ?BaseFormatInterface {

        $formatter = $this->getFormatterFromArray($name);

        if ($formatter) {
            $formatter->setData($data);
        }

        return $formatter;
    }    

    private function getFormatterFromArray(string $name): ?BaseFormat {
        $filteredFormatters = array_filter($this->formatters, function ($formatter) use ($name) {
            return $formatter->getName() === $name;    
        });

        if(count($filteredFormatters)) {
            return reset($filteredFormatters);
        }

        return null;
    }
}

?>

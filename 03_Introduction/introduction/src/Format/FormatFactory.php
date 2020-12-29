<?php

/**
* @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
* @copyright 2020 Wayfair LLC - All rights reserved
*/
declare(strict_types=1);

namespace App\Format;

class FormatFactory {
    public function getFormatter(string $formatterType, array $data): ?BaseFormatInterface {
        switch($formatterType) {
            case 'JSON':
                return new JSON($data);
            case 'XML':
                return new XML($data);
            case 'YAML':
            case 'YML':
                return new YAML($data);
        }
        return null;
    }    
}

?>

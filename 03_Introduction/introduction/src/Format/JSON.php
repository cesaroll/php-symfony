<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App\Format;

class JSON extends BaseFormat {

    public function convert(): string {
        return json_encode($this->data, JSON_THROW_ON_ERROR);
    }


    public function convertFromString(string $string): array {
        return json_decode($string, true);
    }

    public function getName(): string {
        return 'JSON';
    }
}
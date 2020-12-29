<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App\Format;

interface BaseFormatInterface extends NamedFormatInterface {
    public function convert(): string;
    public function __toString(): string;
    public function convertFromString(string $string): array;
}

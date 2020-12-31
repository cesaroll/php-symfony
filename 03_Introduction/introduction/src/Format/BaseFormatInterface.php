<?php

declare(strict_types=1);

namespace App\Format;

interface BaseFormatInterface extends NamedFormatInterface {
    public function convert(): string;
    public function setData(array $data): void;
    public function __toString(): string;
    public function convertFromString(string $string): array;
}

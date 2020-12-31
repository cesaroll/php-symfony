<?php

declare(strict_types=1);

namespace App\Format;

class XML extends BaseFormat {

    public function convert(): string {
        $result = '';

        foreach ($this->data as $key => $value) {
            $result .= '<'.$key.'>'.$value.'</'.$key.'>';
        }

        return htmlspecialchars($result);
    }

    public function convertFromString(string $string): array {
        return [];
    }

    public function getName(): string {
        return 'XML';
    }
}

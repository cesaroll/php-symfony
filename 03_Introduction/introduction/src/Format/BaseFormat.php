<?php

declare(strict_types=1);

namespace App\Format;

abstract class BaseFormat implements BaseFormatInterface {

    protected array $data;

    public function __toString(): string {
        return htmlspecialchars($this->convert());
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void {
        $this->data = $data;
    }




}

<?php

declare(strict_types=1);

namespace App\Service;

use App\Format\BaseFormatInterface;

class Serializer {

    private BaseFormatInterface $format;

    public function __construct(BaseFormatInterface $format)
    {
        $this->format = $format;    
    }

    public function serialize(array $data): string {
        $this->format->setData($data);
        return $this->format->convert();
    }
}

?>

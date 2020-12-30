<?php
/**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
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

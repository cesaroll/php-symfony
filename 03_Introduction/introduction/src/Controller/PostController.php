<?php
 /**
 * @author    Cesar Lopez Lerma <clopezlerma@wayfair.com>
 * @copyright 2020 Wayfair LLC - All rights reserved
 */
declare(strict_types=1);

namespace App\Controller;

use App\Service\Serializer;

class PostController {

    private Serializer $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }          

    public function index(): string {
        return $this->serializer->serialize(
            [
                'Action' => 'Post',
                'Time' => time()
            ]
        );
    }
    
}

?>

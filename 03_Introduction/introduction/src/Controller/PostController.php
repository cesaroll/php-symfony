<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Serializer;
use App\Annotations\Route;

/**
 * @Route(route="/posts")
 */
class PostController {

    private Serializer $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }          

    /**
     * @Route(route="/")
     */
    public function index(): string {
        return $this->serializer->serialize(
            [
                'Action' => 'Post',
                'Time' => time()
            ]
        );
    }

    /**
    * @Route(route="/one")
    */ 
    public function one(): string {
        return $this->serializer->serialize(
            [
                'Action' => 'PostOne',
                'Time' => time()
            ]
        );
    }
    
}

?>

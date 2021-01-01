<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController {

    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'hello-world',
            'title' => 'Hello World'
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'This is another post'
        ],
        [
            'id' => 3,
            'slug' => 'last-example',
            'title' => 'This is the last example'
        ],
    ];

    /**
    * @Route("/", name="blog_list")
    */ 
    public function list() {
        return new JsonResponse(self::POSTS);    
    }
    
    /**
     * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post(int $id) {
        return new JsonResponse($this->searchByIdAndColumn($id, 'id'));
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug) {
       return new JsonResponse($this->searchByIdAndColumn($slug, 'slug')); 
    }

    private function searchByIdAndColumn(string $id, string $col): ?array {
        $idx = array_search($id, array_column(self::POSTS, $col));
        //return [$idx];
        if ($idx !== false) {
            return self::POSTS[$idx];
        }
        return null;
    }
}

?>

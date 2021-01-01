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
     * @Route("/{page}", name="blog_list", defaults={"page": 5})
     * @param int $page
     *
     * @return JsonResponse
     */
    public function list(int $page = 1): JsonResponse {
        return new JsonResponse(
            [
                'page' => $page,
                'data' => self::POSTS
            ]
        );
    }

    /**
     * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
     * @param int $id
     *
     * @return JsonResponse
     */
    public function post(int $id): JsonResponse {
        return new JsonResponse($this->searchByIdAndColumn($id, 'id'));
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     * @param $slug
     *
     * @return JsonResponse
     */
    public function postBySlug($slug): JsonResponse {
       return new JsonResponse($this->searchByIdAndColumn($slug, 'slug')); 
    }

    private function searchByIdAndColumn(string $id, string $col): ?array {
        $idx = array_search($id, array_column(self::POSTS, $col), true);
        //return [$idx];
        if ($idx !== false) {
            return self::POSTS[$idx];
        }
        return null;
    }
}

?>

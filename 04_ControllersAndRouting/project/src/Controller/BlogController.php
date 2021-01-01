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
     *
     * @param int $page
     *
     * @return JsonResponse
     */
    public function list(int $page = 1): JsonResponse {
        return new JsonResponse(
            [
                'page' => $page,
                'data' => array_map(function ($item) {
                    return $this->generateUrl('blog_by_id', ['id' => $item['id']]);
                }, self::POSTS)
            ]
        );
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
     * @param int $id
     *
     * @return JsonResponse
     */
    public function post(int $id): JsonResponse {
        $idx = array_search($id, array_column(self::POSTS, 'id'), true);
        if ($idx !== false) {
            return new JsonResponse(self::POSTS[$idx]);
        }
        return new JsonResponse(self::POSTS[$idx]);
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug")
     *
     * @param string $slug
     *
     * @return JsonResponse
     */
    public function postBySlug(string $slug): JsonResponse {
        $idx = array_search($slug, array_column(self::POSTS, 'slug'), true);
        if ($idx !== false) {
            return new JsonResponse(self::POSTS[$idx]);
        }
        return new JsonResponse(self::POSTS[$idx]);
    }


//    /**
//     * @Route("/{page}", name="blog_list", defaults={"page": 5})
//     * @param int $page
//     *
//     * @return JsonResponse
//     */
//    public function list(int $page = 1): JsonResponse {
//        return new JsonResponse(
//            [
//                'page' => $page,
//                'data' => array_map(function ($item) {
//                    return $this->generateUrl('blog_by_id', ['id' => $item['id']]);
//                }, self::POSTS)
//            ]
//        );
//    }
//
//    /**
//     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
//     * @param int $id
//     *
//     * @return JsonResponse
//     */
//    public function post(int $id): JsonResponse {
//        return new JsonResponse($this->searchByIdAndColumn($id, 'id'));
//    }
//
//    /**
//     * @Route("/post/{slug}", name="blog_by_slug")
//     * @param $slug
//     *
//     * @return JsonResponse
//     */
//    public function postBySlug($slug): JsonResponse {
//        return new JsonResponse($this->searchByIdAndColumn($slug, 'slug'));
//    }
}

?>

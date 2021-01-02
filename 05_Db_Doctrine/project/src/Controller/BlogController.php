<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response
     */
    public function list(int $page = 1, Request $request): Response {
        $limit= $request->get('limit', 10);

        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
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
     * @return Response
     */
    public function post(int $id): Response {
        $idx = array_search($id, array_column(self::POSTS, 'id'), true);
        if ($idx !== false) {
            return $this->json(self::POSTS[$idx]);
        }
        return $this->json(self::POSTS[$idx]);
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug")
     *
     * @param string $slug
     *
     * @return Response
     */
    public function postBySlug(string $slug): Response {
        $idx = array_search($slug, array_column(self::POSTS, 'slug'), true);
        if ($idx !== false) {
            return $this->json(self::POSTS[$idx]);
        }
        return $this->json(self::POSTS[$idx]);
    }
}

?>

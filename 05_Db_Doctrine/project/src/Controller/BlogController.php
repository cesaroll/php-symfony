<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Model\BlogPostModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

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
     * @Route("/{page}", name="blog_list", defaults={"page": 5}, requirements={"page"="\d+"}, methods={"GET"})
     *
     * @param int     $page
     * @param Request $request
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
     * @Route("/by_id/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     * @param int $id
     *
     * @return Response
     */
    public function by_id(int $id): Response {
        $idx = array_search($id, array_column(self::POSTS, 'id'), true);
        if ($idx !== false) {
            return $this->json(self::POSTS[$idx]);
        }
        return $this->json(self::POSTS[$idx]);
    }

    /**
     * @Route("/by_slug/{slug}", name="blog_by_slug", methods={"GET"})
     *
     * @param string $slug
     *
     * @return Response
     */
    public function by_slug(string $slug): Response {
        $idx = array_search($slug, array_column(self::POSTS, 'slug'), true);
        if ($idx !== false) {
            return $this->json(self::POSTS[$idx]);
        }
        return $this->json(self::POSTS[$idx]);
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function add(Request $request): Response {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $blogPostModel = $serializer->deserialize($request->getContent(), BlogPostModel::class, 'json');

        

        return $this->json($blogPost);
//
//        $blogPost = new BlogPost();
//        $blogPost->setTitle('AAAA new blog post!');
//        $blogPost->setPublished($this->getDateTimeNow());
//        $blogPost->setContent('Hola');
//        $blogPost->setAuthor('Romel');
//        $blogPost->setSlug('a-new-romel-post');
//
//        $serialized = $serializer->serialize($blogPost, 'json');
//        return $this->json($serialized);

//        $em = $this->getDoctrine()->getManager();
//        $em->persist($blogPost);
//        $em->flush();

//        return $this->json($blogPost);
    }

    private function getDateTimeNow(): \DateTimeInterface {
        return new \DateTimeImmutable('now');
    }
}



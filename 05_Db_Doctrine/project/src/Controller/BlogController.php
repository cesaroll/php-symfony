<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Mapper\BlogPostMapper;
use App\Model\BlogPostModel;
use AutoMapperPlus\AutoMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController {

    private SerializerInterface $serializer;
    private AutoMapper $mapper;

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
     * BlogController constructor.
     *
     * @param SerializerInterface $serializer
     * @param BlogPostMapper      $mapper
     */
    public function __construct(
        SerializerInterface $serializer,
        BlogPostMapper $mapper
    ) {
        $this->serializer = $serializer;
        $this->mapper = $mapper->getAutoMapper();
    }


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
     * @param Request        $request
     * @param BlogPostMapper $mapper
     *
     * @return Response
     */
    public function add(Request $request, BlogPostMapper $mapper): Response {

        $blogPostModel = $this->serializer->deserialize($request->getContent(), BlogPostModel::class, 'json');

        $blogPost = $mapper->toBlogPost($blogPostModel);
        $blogPost->setPublished($this->getDateTimeNow());

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }

    private function getDateTimeNow(): \DateTimeInterface {
        return new \DateTimeImmutable('now');
    }
}



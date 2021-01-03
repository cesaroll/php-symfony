<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Mapper\BlogPostMapper;
use App\Model\BlogPostModel;
use App\Repository\BlogPostRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use DateTimeInterface;
use DateTimeImmutable;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController {

    private SerializerInterface $serializer;
    private BlogPostRepository $repository;
    private BlogPostMapper $mapper;

    /**
     * BlogController constructor.
     *
     * @param SerializerInterface $serializer
     * @param BlogPostRepository  $repository
     * @param BlogPostMapper      $mapper
     */
    public function __construct(
        SerializerInterface $serializer,
        BlogPostRepository $repository,
        BlogPostMapper $mapper
    ) {
        $this->serializer = $serializer;
        $this->repository = $repository;
        $this->mapper = $mapper;
    }


    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 5}, requirements={"page"="\d+"}, methods={"GET"})
     *
     * @param int                $page
     * @param Request            $request
     * @param BlogPostRepository $repository
     *
     * @return Response
     */
    public function list(
        int $page = 1,
        Request $request,
        BlogPostRepository $repository
    ): Response {
        $limit= $request->get('limit', 10);

        $items = $repository->findAll();

        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function (BlogPost $item) {
                    return $this->generateUrl('blog_by_id', ['id' => $item->getId()]);
                }, $items)
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
        return $this->json($this->repository->find($id));
    }

    /**
     * @Route("/by_slug/{slug}", name="blog_by_slug", methods={"GET"})
     *
     * @param string $slug
     *
     * @return Response
     */
    public function by_slug(string $slug): Response {
        return $this->json($this->repository->findBy(['slug' => $slug]));
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

    /**
     * @Route("/{id}", methods={"DELETE"}, name="blog_delete", requirements={"id"="\d+"})
     * @param int $id
     *
     * @return Response
     */
    public function delete(int $id): Response {
        $blogPost = $this->repository->find($id);

        if ($blogPost) {
            $em = $this->getEntityManager();
            $em->remove($blogPost);
            $em->flush();
        }

        return $this->json(null,Response::HTTP_NO_CONTENT);
    }

    private function getEntityManager(): ObjectManager {
        return $this->getDoctrine()->getManager();
    }

    private function getDateTimeNow(): DateTimeInterface {
        return new DateTimeImmutable('now');
    }
}



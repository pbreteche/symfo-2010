<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", methods="GET")
 */
class PostController extends AbstractController
{
    /**
     * @Route("")
     */
    public function index(PostRepository $repository): Response
    {
        $posts = $repository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function detail(Post $post): Response
    {
        return $this->render('post/detail.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $post = new Post();
        $post->setPublishedAt(new \DateTimeImmutable('now'));

        $form = $this->createFormBuilder($post)
            ->add('title')
            ->add('author')
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('content')
            ->add('isPublished')
            ->getForm();

        return $this->render('post/create.html.twig', [
            'create_form' => $form->createView(),
        ]);
    }
}

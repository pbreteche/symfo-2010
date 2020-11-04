<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", methods="GET")
     */
    public function index(PostRepository $repository): Response
    {
        $posts = $repository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}

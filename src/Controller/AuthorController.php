<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author", methods="GET")
 */
class AuthorController extends AbstractController
{

    /**
     * @Route("")
     */
    public function index(AuthorRepository $repository)
    {
        $authors = $repository->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/{id}/posts")
     */
    public function posts(Author $author, PostRepository $postRepository)
    {
        $posts = $postRepository->findBy(['writtenBy' => $author]);

        return $this->render('author/posts.html.twig', [
            'author' => $author,
            'posts' => $posts,
        ]);
    }

    /**
     * @Cache(expires="+1 day")
     */
    public function resume(Author $author, PostRepository $postRepository)
    {
        $contributionCount = $postRepository->count(['writtenBy' => $author]);

        return $this->render('author/resume.html.twig', [
            'author' => $author,
            'count' => $contributionCount,
        ]);
    }
}

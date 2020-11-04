<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", methods="GET")
     */
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'twig_variable_name' => 'ma valeur',
        ]);
    }
}

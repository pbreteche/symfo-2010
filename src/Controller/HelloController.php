<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends AbstractController
{

    public function demo1()
    {
        return new Response('Yes, ça marche !!!');
    }
}

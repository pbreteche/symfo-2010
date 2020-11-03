<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends AbstractController
{

    public function demo1()
    {
        return new Response('Yes, ça marche !!!');
    }

    public function demo2(string $name, Request $request)
    {
        $httpMethod = $request->getMethod();
        // query-string
        $option = $request->query->get('city', 'Nantes');

        // body
        $data = $request->request->get('country', 'FR');

        $request->getSession()->get('locale', 'fr');

        return new Response('Bonjour '.$name.' !');
    }

    public function demo3(int $id)
    {
        return new Response('L\'article numéro: '.$id.'.');
    }
}

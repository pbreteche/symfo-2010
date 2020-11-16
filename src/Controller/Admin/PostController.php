<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{


    /**
     * @Route("/new", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $post = new Post();
        $post->setPublishedAt(new \DateTimeImmutable('now'));

        $form = $this->createForm(PostType::class, $post, [
            'validation_groups' => ['Default', 'Creation'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', 'Bravo, vous avez réussi l\'exploit de créer un article');

            return $this->redirectToRoute('app_post_detail', ['id' => $post->getId()]);
        }

        return $this->render('post/create.html.twig', [
            'create_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "PUT"})
     */
    public function update(Post $post, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PostType::class, $post, [
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Bravo, vous avez transformé un article naze en article formidable');

            return $this->redirectToRoute('app_post_detail', ['id' => $post->getId()]);
        }

        return $this->render('post/update.html.twig', [
            'create_form' => $form->createView(),
        ]);
    }
}
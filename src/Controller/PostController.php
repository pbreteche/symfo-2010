<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $posts = $repository->findLatestPublished2();

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

        dump($post);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Bravo, vous avez transformé un article naze en article formidable');

            return $this->redirectToRoute('app_post_detail', ['id' => $post->getId()]);
        }

        return $this->render('post/update.html.twig', [
            'create_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search")
     */
    public function search(Request $request)
    {
        return $this->render('post/search.html.twig');
    }
}

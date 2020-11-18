<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{


    /**
     * @Route("/new", methods={"GET", "POST"})
     */
    public function create(
        Request $request,
        EntityManagerInterface $manager,
        TranslatorInterface $translator
    ): Response {
        $post = new Post();
        $post->setPublishedAt(new \DateTimeImmutable('now'));
        $post->setWrittenBy($this->getUser()->getAuthor());

        $this->denyAccessUnlessGranted('POST_CREATE', $post);

        $form = $this->createForm(PostType::class, $post, [
            'validation_groups' => ['Default', 'Creation'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', $translator->trans('post.create.success'));

            return $this->redirectToRoute('app_post_detail', ['id' => $post->getId()]);
        }

        return $this->render('admin/post/create.html.twig', [
            'create_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "PUT"})
     * @IsGranted("POST_EDIT", subject="post")
     */
    public function update(
        Post $post,
        Request $request,
        EntityManagerInterface $manager,
        TranslatorInterface $translator
    ): Response {
        $form = $this->createForm(PostType::class, $post, [
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', $translator->trans('post.update.success'));

            return $this->redirectToRoute('app_post_detail', ['id' => $post->getId()]);
        }

        return $this->render('admin/post/update.html.twig', [
            'create_form' => $form->createView(),
        ]);
    }
}
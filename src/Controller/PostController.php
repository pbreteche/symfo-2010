<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Util\StringManipulator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({
 *     "en": "/post",
 *     "fr": "/publication",
 * }, methods="GET")
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
    public function detail(Request $request, Post $post): Response
    {
        $etag = md5($post->getTitle().$post->getContent());

        $response = new Response();
        $response->setEtag($etag);

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response->setContent($this->renderView('post/detail.html.twig', [
            'post' => $post,
        ]));
    }

    /**
     * @Route({
     *     "en": "/search",
     *     "fr": "/chercher"
     * })
     */
    public function search(
        Request $request,
        PostRepository $repository,
        StringManipulator $stringManipulator
    ): Response {
        $searchQuery = $request->query->get('q', '');

        $cleanSearchQuery = $stringManipulator->cleanUserInput($searchQuery);

        $posts = [];

        if ($cleanSearchQuery) {
            $posts = $repository->findByTitleLike($cleanSearchQuery);
        }

        return $this->render('post/search.html.twig', [
            'posts' => $posts,
        ]);
    }
}

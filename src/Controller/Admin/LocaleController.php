<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocaleController extends AbstractController
{

    /**
     * @Route("/locale/{locale}", requirements={"locale": "en|fr"})
     */
    public function select(string $locale, Request $request, TranslatorInterface $translator): Response
    {
        $request->getSession()->set('locale', $locale);

        $this->addFlash('success', $translator->trans('admin.locale.select_success', [
            'locale' => $locale
        ]));

        return $this->redirectToRoute('app_admin_post_create');
    }
}
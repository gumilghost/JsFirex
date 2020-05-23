<?php

namespace App\Controller;

use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @param LinkRepository $linkRepository
     * @return RedirectResponse
     * @Route("/", methods={"get"}, name="home")
     */
    public function index(LinkRepository $linkRepository): Response
    {
        try {
            $link = $linkRepository->getRandomLink();
        } catch (\Exception $e) {
            return $this->render('default/home.html.twig', [
                'link' => ['reference' => '', 'title' => ''],
                'error' => $e->getMessage()
            ]);
        }

        return $this->render('default/home.html.twig', [
            'link' => $link,
            'error' => null,
        ]);
    }
}

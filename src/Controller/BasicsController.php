<?php

namespace App\Controller;

use App\Repository\LinkRepository;
use GpsLab\Bundle\PaginationBundle\Service\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasicsController extends AbstractController
{
    /**
     * @param Configuration $pagination
     * @param LinkRepository $linkRepository
     * @param int $page
     * @param string $language
     * @return Response
     * @Route(
     *     "/basics/{language}/{page}",
     *     methods={"get"},
     *     name="basics",
     *     requirements={"page"="\d+", "language"="(JavaScript)"}
     *     )
     */
    public function showBasics(
        Configuration $pagination,
        LinkRepository $linkRepository,
        string $language,
        int $page = 1
    ): Response {
        try {
            $totalLinks = $linkRepository->getTotalLanguageLinks($language);
        } catch (\Exception $e) {
            return $this->render('basics/index.html.twig', [
                'language' => $language,
                'links' => [],
                'paginator' => null,
                'error' => $e->getMessage(),
                'count' => 0
            ]);
        }

        $pagination->setTotalPages(ceil($totalLinks / $this->getParameter('resultsPerPage')));
        $pagination->setCurrentPage($page);

        return $this->render('basics/index.html.twig', [
            'language' => $language,
            'links' => $linkRepository->getLanguageLinks(
                $language,
                $page,
                $this->getParameter('resultsPerPage')
            ),
            'paginator' => $pagination,
            'totalLinks' => $totalLinks
        ]);
    }
}

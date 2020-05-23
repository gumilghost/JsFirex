<?php

namespace App\Controller;

use App\Entity\Language;
use App\Repository\LinkRepository;
use GpsLab\Bundle\PaginationBundle\Service\Configuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasicsController extends AbstractController
{
    /**
     * @param Configuration $pagination
     * @param LinkRepository $linkRepository
     * @param Language $language
     * @param int $page
     * @return Response
     * @Route(
     *     "/basics/{language}/{page}",
     *     methods={"get"},
     *     name="basics",
     *     requirements={"page"="\d+"}
     *     )
     * @Entity("language", expr="repository.getLanguageByName(language)")
     */
    public function showBasics(
        Configuration $pagination,
        LinkRepository $linkRepository,
        Language $language,
        int $page = 1
    ): Response {
        try {
            $totalLinks = $linkRepository->getTotalLanguageLinks($language);
        } catch (\Exception $e) {
            return $this->render('other/internal-error.html.twig', [
                'error' => $e->getMessage(),
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

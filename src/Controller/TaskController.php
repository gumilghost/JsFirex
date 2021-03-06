<?php

namespace App\Controller;

use App\Entity\Language;
use App\Repository\TaskRepository;
use App\Service\PaginationHelper;
use GpsLab\Bundle\PaginationBundle\Service\Configuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route(
     *     "/{language}/tasks/{page}",
     *     name="tasks",
     *     methods={"get"},
     *     requirements={"page"="\d+"}
     *     )
     * @Entity("language", expr="repository.getLanguageByName(language)")
     * @param Configuration $pagination
     * @param TaskRepository $taskRepository
     * @param Language $language
     * @param PaginationHelper $paginationHelper
     * @param int $page
     * @return Response
     */
    public function index(
        Configuration $pagination,
        TaskRepository $taskRepository,
        Language $language,
        PaginationHelper $paginationHelper,
        int $page = 1
    ): Response {
        try {
            $totalTasks = $taskRepository->getTotalLanguageTasks($language);
        } catch (\Exception $e) {
            return $this->render('other/internal-error.html.twig', [
                'error' => $e->getMessage(),
            ]);
        }

        $pagination->setTotalPages($paginationHelper->calculateTotalPages($totalTasks));
        $pagination->setCurrentPage($page);

        return $this->render('task/index.html.twig', [
            'language' => $language,
            'tasks' => $taskRepository->getLanguageTasks(
                $language,
                $page,
                $this->getParameter('resultsPerPage')
            ),
            'paginator' => $pagination,
            'totalTasks' => $totalTasks
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use GpsLab\Bundle\PaginationBundle\Service\Configuration;
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
     *     requirements={"page"="\d+", "language"="(JavaScript)"}
     *     )
     * @param Configuration $pagination
     * @param TaskRepository $taskRepository
     * @param int $page
     * @param string $language
     * @return Response
     */
    public function index(
        Configuration $pagination,
        TaskRepository $taskRepository,
        int $page = 1,
        string $language = 'JavaScript'
    ): Response {
        try {
            $totalTasks = $taskRepository->getTotalLanguageTasks($language);
        } catch (\Exception $e) {
            return $this->render('task/index.html.twig', [
                'language' => $language,
                'tasks', [],
                'paginator' => null,
                'error' => $e->getMessage()
            ]);
        }

        $pagination->setTotalPages(ceil($totalTasks / $this->getParameter('resultsPerPage')));
        $pagination->setCurrentPage($page);

        return $this->render('task/index.html.twig', [
            'language' => $language,
            'tasks' => $taskRepository->getLanguageTasks(
                $language,
                $page,
                $this->getParameter('resultsPerPage')
            ),
            'paginator' => $pagination
        ]);
    }
}

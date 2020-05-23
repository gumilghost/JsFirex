<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseReferenceRepository;
use GpsLab\Bundle\PaginationBundle\Service\Configuration;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    /**
     * @Route("/courses/{page}", name="courses", requirements={"page"="/d+"})
     * @param Configuration $pagination
     * @param CourseRepository $courseRepository
     * @param int $page
     * @return Response
     */
    public function index(Configuration $pagination, CourseRepository $courseRepository, int $page = 1): Response
    {
        try {
            $totalCourses = $courseRepository->getTotalCourses(null);
        } catch (\Exception $e) {
            return $this->render('other/internal-error.html.twig', [
                $e->getMessage(),
            ]);
        }

        $courses = $courseRepository->getCourses($page, $this->getParameter('resultsPerPage'));

        $pagination->setTotalPages(ceil($totalCourses / $this->getParameter('resultsPerPage')));
        $pagination->setCurrentPage($page);

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
            'page' => $page,
            'paginator' => $pagination,
            'totalCourses' => $totalCourses,
        ]);
    }

    /**
     * @param CourseReferenceRepository $courseReferenceRepository
     * @param Configuration $pagination
     * @param Course $course
     * @param int $page
     * @return Response
     * @Route("/course/{id}/page/{page}", methods={"get"}, name="course", requirements={"page"="/d+"})
     */
    public function displayCourse(
        CourseReferenceRepository $courseReferenceRepository,
        Configuration $pagination,
        Course $course,
        int $page = 1
    ): Response {
        try {
            $totalReferences = $courseReferenceRepository->getTotalCourseReferences($course);
        } catch (\Exception $e) {
            return $this->render('other/internal-error.html.twig', [
                'error' => $e->getMessage(),
            ]);
        }

        $pagination->setTotalPages(ceil($totalReferences / $this->getParameter('resultsPerPage')));
        $pagination->setCurrentPage($page);

        return $this->render('course/course.html.twig', [
            'course' => $course,
            'page' => $page,
            'paginator' => $pagination,
            'totalReferences' => $totalReferences,
        ]);
    }
}

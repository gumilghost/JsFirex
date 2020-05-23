<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\CourseReference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourseReference|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseReference|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseReference[]    findAll()
 * @method CourseReference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseReference::class);
    }

    /**
     * @param Course $course
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalCourseReferences(Course $course): int
    {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->select('COUNT(c.id)')
            ->where('c.course = :COURSE')
            ->setParameter('COURSE', $course)
            ->getQuery()
            ->getSingleScalarResult();
    }
}

<?php

namespace App\Repository;

use App\Entity\Language;
use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @param int $page
     * @param int $resultsPerPage
     * @return array
     */
    public function getCourses(int $page, int $resultsPerPage): array
    {
        $qb = $this->createQueryBuilder('c');
        $query = $qb
            ->setFirstResult(($page * $resultsPerPage) - $resultsPerPage)
            ->setMaxResults($resultsPerPage)
            ->orderBy('c.author', 'asc')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param Language|null $language
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalCourses(?Language $language): int
    {
        $qb = $this->createQueryBuilder('c');

        $query = $qb->select('COUNT(c.id)');

        if ($language) {
            $query = $query
                ->where('c.language = :LANGUAGE')
                ->setParameter('LANGUAGE', $language);
        }

        return $query->getQuery()->getSingleScalarResult();
    }
}

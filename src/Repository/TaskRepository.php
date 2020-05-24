<?php

namespace App\Repository;

use App\Entity\Language;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param Language $language
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getTotalLanguageTasks(Language $language): int
    {
        $qb = $this->createQueryBuilder('t');
        $query = $qb
            ->select('COUNT(t.id)')
            ->where('t.language = :LANGUAGE')
            ->setParameter('LANGUAGE', $language);

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * @param Language $language
     * @param int $page
     * @param int $resultsPerPage
     * @return array
     */
    public function getLanguageTasks(Language $language, int $page, int $resultsPerPage): array
    {
        $qb = $this->createQueryBuilder('t');
        $query = $qb
            ->where('t.language = :LANGUAGE')
            ->setParameter('LANGUAGE', $language)
            ->orderBy('t.difficulty', 'asc')
            ->setFirstResult(($page * $resultsPerPage) - $resultsPerPage)
            ->setMaxResults($resultsPerPage)
            ->getQuery();

        return $query->getArrayResult();
    }
}

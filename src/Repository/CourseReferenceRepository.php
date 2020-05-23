<?php

namespace App\Repository;

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

    // /**
    //  * @return CourseReference[] Returns an array of CourseReference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourseReference
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

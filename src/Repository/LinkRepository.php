<?php

namespace App\Repository;

use App\Entity\Language;
use App\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Link|null find($id, $lockMode = null, $lockVersion = null)
 * @method Link|null findOneBy(array $criteria, array $orderBy = null)
 * @method Link[]    findAll()
 * @method Link[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    /**
     * @param Language $language
     * @param int $page
     * @param int $resultsPerPage
     * @return array
     */
    public function getLanguageLinks(Language $language, int $page, int $resultsPerPage): array
    {
        $qb = $this->createQueryBuilder('l');
        $query = $qb
            ->where('l.language = :LANGUAGE')
            ->setParameter('LANGUAGE', $language)
            ->orderBy('l.created', 'asc')
            ->setFirstResult(($page * $resultsPerPage) - $resultsPerPage)
            ->setMaxResults($resultsPerPage)
            ->getQuery();

        return $query->getArrayResult();
    }

    /**
     * @param Language $language
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getTotalLanguageLinks(Language $language): int
    {
        $qb = $this->createQueryBuilder('l');
        $query = $qb
            ->select('COUNT(l.id)')
            ->where('l.language = :LANGUAGE')
            ->setParameter('LANGUAGE', $language);

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * @param Language $language
     * @return Link
     * @throws NonUniqueResultException
     */
    public function getRandomLink(?Language $language = null): ?Link
    {
        $identifiers = $this->getLinksId($language);
        if (!$identifiers) {
            return null;
        }

        $qb = $this->createQueryBuilder('l');
        $query = $qb
            ->where('l.id = :ID')
            ->setParameter('ID', $identifiers[mt_rand(0, count($identifiers) - 1)]);

        if ($language) {
            $query = $query
                ->where('l.language = :LANGUAGE')
                ->setParameter('LANGUAGE', $language);
        }

        $query = $query->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param Language $language
     * @return array
     */
    public function getLinksId(?Language $language = null): array
    {
        $qb = $this->createQueryBuilder('l');
        $query = $qb->select('l.id');

        if ($language) {
            $query = $query
                ->where('l.language = :LANGUAGE')
                ->setParameter('LANGUAGE', $language);
        }

        $query = $query->getQuery();

        return array_column($query->getArrayResult(), 'id');
    }
}

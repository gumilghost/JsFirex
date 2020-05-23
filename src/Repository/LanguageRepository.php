<?php

namespace App\Repository;

use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Language|null find($id, $lockMode = null, $lockVersion = null)
 * @method Language|null findOneBy(array $criteria, array $orderBy = null)
 * @method Language[]    findAll()
 * @method Language[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Language::class);
    }

    /**
     * @param string $name
     * @return Language|null
     */
    public function getLanguageByName(string $name): ?Language
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function getLanguagesAsArray(): array
    {
        $qb = $this->createQueryBuilder('l');
        $result = $qb->select('l.name')->getQuery()->getArrayResult();
        return array_column($result, 'name');
    }
}

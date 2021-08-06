<?php

namespace App\Repository;

use App\Entity\ПGenre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ПGenre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ПGenre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ПGenre[]    findAll()
 * @method ПGenre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ПGenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ПGenre::class);
    }

    // /**
    //  * @return ПGenre[] Returns an array of ПGenre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('�')
            ->andWhere('�.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('�.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ПGenre
    {
        return $this->createQueryBuilder('�')
            ->andWhere('�.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

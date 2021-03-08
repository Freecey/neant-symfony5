<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[]
     */
    public function findCatWindows(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.category = 0')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[]
     */
    public function findCatLinux(): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.category = 1')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[]
     */
    public function findCatOther() :array
    {
        return $this->createQueryBuilder('a')
            ->where('a.category = 2')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[]
     */
    public function find5Latest() :array
    {
        return $this->createQueryBuilder('a')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

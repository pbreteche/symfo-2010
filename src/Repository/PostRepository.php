<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findLatestPublished()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT p FROM '.Post::class.' p WHERE p.isPublished = 1 ORDER BY p.publishedAt DESC'
        )->getResult();
    }

    public function findLatestPublished2()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isPublished = 1')
            ->orderBy('p.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByTitleLike(string $cleanSearchQuery)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :term')
            ->getQuery()
            ->setParameter('term', '%'.$cleanSearchQuery.'%')
            ->getResult();
    }
}

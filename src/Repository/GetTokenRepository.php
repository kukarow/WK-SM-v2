<?php

namespace App\Repository;

use App\Entity\GetToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GetToken>
 *
 * @method GetToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method GetToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method GetToken[]    findAll()
 * @method GetToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GetTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GetToken::class);
    }

//    /**
//     * @return GetToken[] Returns an array of GetToken objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GetToken
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

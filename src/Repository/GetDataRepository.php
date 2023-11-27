<?php

namespace App\Repository;

use App\Entity\GetData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GetData>
 *
 * @method GetData|null find($id, $lockMode = null, $lockVersion = null)
 * @method GetData|null findOneBy(array $criteria, array $orderBy = null)
 * @method GetData[]    findAll()
 * @method GetData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GetDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GetData::class);
    }

//    /**
//     * @return GetData[] Returns an array of GetData objects
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

//    public function findOneBySomeField($value): ?GetData
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\VirtualRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VirtualRoom>
 *
 * @method VirtualRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method VirtualRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method VirtualRoom[]    findAll()
 * @method VirtualRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VirtualRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VirtualRoom::class);
    }

//    /**
//     * @return VirtualRoom[] Returns an array of VirtualRoom objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VirtualRoom
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

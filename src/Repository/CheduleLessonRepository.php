<?php

namespace App\Repository;

use App\Entity\ScheduleLesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScheduleLesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduleLesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduleLesson[]    findAll()
 * @method ScheduleLesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheduleLessonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScheduleLesson::class);
    }

    // /**
    //  * @return CheduleLesson[] Returns an array of CheduleLesson objects
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
    public function findOneBySomeField($value): ?CheduleLesson
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

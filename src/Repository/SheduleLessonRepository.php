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
class SheduleLessonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScheduleLesson::class);
    }

     /**
      * @return ScheduleLesson[] Returns an array of ScheduleLesson objects
      */

    public function findByTeacherField($teacherId)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('s.teacher= ?1')
            ->leftJoin('l.student','s')
            ->orderBy('l.dayOfTheWeek', 'ASC')
            ->orderBy('l.time','ASC')
            ->setParameter('1',$teacherId)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return ScheduleLesson[] Returns an array of ScheduleLesson objects
     */

    public function findByTeacherFieldLessonDueDay($teacherId,$day)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('s.teacher= ?1')
            ->andWhere('l.dayOfTheWeek=?2')
            ->leftJoin('l.student','s')
            ->orderBy('l.time','ASC')
            ->setParameter('1',$teacherId)
            ->setParameter('2',$day)
            ->getQuery()
            ->getResult()
            ;
    }


//select * from schedule_lesson as l JOIN (SELECT id from student as s where s.teacher_id=3) as stud ON l.student_id=stud.id;
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

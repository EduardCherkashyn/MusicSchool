<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    // /**
    //  * @return Lesson[] Returns an array of Lesson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function getQueryLessonCrud($teacherId)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('s.teacher= ?1')
            ->leftJoin('l.student','s')
            ->addOrderBy('l.date', 'DESC')
            ->setParameter('1',$teacherId)
            ->getQuery();
    }

    public function getAvailableDatesForResults($teacherId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT YEAR(lesson.date) as year, MONTHNAME(lesson.date) as month from lesson JOIN (SELECT id from student as s where s.teacher_id=:teacherId) as stud ON lesson.student_id=stud.id  GROUP BY year, month';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('teacherId',$teacherId);
        $stmt->execute();

        return $stmt->fetchAll();
    }
//SELECT YEAR(lesson.date) as year, MONTHNAME(lesson.date) as month from lesson JOIN (SELECT id from student as s where s.teacher_id=3) as stud ON lesson.student_id=stud.id GROUP BY year, month;
    public function getLessonsForResults($year, $month, $teacher)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('YEAR(l.date) = ?1')
            ->andWhere('MONTHNAME(l.date) = ?2')
            ->andWhere('s.teacher= ?3')
            ->leftJoin('l.student','s')
            ->addOrderBy('l.student', 'DESC')
            ->setParameter(1, $year)
            ->setParameter(2,$month)
            ->setParameter(3,$teacher)
            ->getQuery()
            ->getResult();
    }

    public function getStudentLesson($studendId)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.student = ?1')
            ->addOrderBy('l.date', 'DESC')
            ->setParameter(1, $studendId)
            ->getQuery();
    }

}

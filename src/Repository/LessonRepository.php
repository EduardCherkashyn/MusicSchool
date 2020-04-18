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


    public function getQueryLessonCrud()
    {
        return $this->createQueryBuilder('l')
            ->addOrderBy('l.date', 'DESC')
            ->getQuery();
    }

    public function getAvailableDatesForResults()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT YEAR(lesson.date) as year, MONTHNAME(lesson.date) as month from lesson GROUP BY year, month';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getLessonsForResults($year, $month)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('YEAR(l.date) = ?1')
            ->andWhere('MONTHNAME(l.date) = ?2')
            ->addOrderBy('l.student', 'DESC')
            ->setParameter(1, $year)
            ->setParameter(2,$month)
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

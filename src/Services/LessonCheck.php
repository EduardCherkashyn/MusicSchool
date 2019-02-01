<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2019-02-01
 * Time: 18:57
 */

namespace App\Services;

use App\Entity\Lesson;
use App\Entity\Student;

class LessonCheck
{
    public function beforePutMark(Student $student)
    {
        $lessons = $student->getLessonsArchive();
        if (!$lessons->isEmpty()) {
            /**
             * @var Lesson $lesson
             */
            $lesson = $lessons->last();
        } else {
            $lesson = null;
        }

        return $lesson;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 11/28/18
 * Time: 7:10 PM
 */

namespace App\Services;


use App\Entity\ScheduleLesson;

class SortingByDay
{
    public static function indexAction(array $lessons)
    {
        usort($lessons, function(ScheduleLesson $a, ScheduleLesson $b) {
            return $a->getTime()->format('U') - $b->getTime()->format('U');
        });

        return $lessons;
    }
}
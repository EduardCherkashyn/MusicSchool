<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-04-05
 * Time: 13:13
 */

namespace App\Services;

use App\Entity\ScheduleLesson;

class ScheduleSorting
{
    /**
     * @param array ScheduleLesson[] $lessons
     */
    public function sort(array $lessons) :array
    {
        $sortedData = [];
        /** @var ScheduleLesson $lesson */
        foreach ($lessons as $lesson){
            switch($lesson->getDayOfTheWeek()){
                case 1:
                    $sortedData['Monday'][] = $lesson;
                    break;
                case 2:
                    $sortedData['Tuesday'][] = $lesson;
                    break;
                case 3:
                    $sortedData['Wednesday'][] = $lesson;
                    break;
                case 4:
                    $sortedData['Thursday'][] = $lesson;
                    break;
                case 5:
                    $sortedData['Friday'][] = $lesson;
                    break;
                case 6:
                    $sortedData['Saturday'][] = $lesson;
                    break;
            }
        }

        return $sortedData;

    }
}

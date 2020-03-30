<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-03-30
 * Time: 19:35
 */

namespace App\Services;

use App\Entity\Student;
use RicardoFiorani\Matcher\VideoServiceMatcher;


class UrlParser
{
    public function parse(Student $student) :void
    {
        $vsm = new VideoServiceMatcher();
        foreach ($student->getLessonsArchive() as $lesson) {
            if($lesson->getYoutubeLink()){
            $video = $vsm->parse($lesson->getYoutubeLink());
            $link = $video->getEmbedUrl();
            $lesson->setYoutubeLink($link);
            }
        }
    }
}

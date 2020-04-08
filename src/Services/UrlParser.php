<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-03-30
 * Time: 19:35
 */

namespace App\Services;

use App\Entity\Lesson;
use App\Entity\Student;
use App\Repository\VideoRepository;
use RicardoFiorani\Matcher\VideoServiceMatcher;


class UrlParser
{
    private $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

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

    public function parseOneLink(Lesson $lesson)
    {
        $vsm = new VideoServiceMatcher();
        $video = $vsm->parse($lesson->getYoutubeLink());
        $link = $video->getEmbedUrl();
        $lesson->setYoutubeLink($link);
    }

    public function parseUrl() :array
    {
        $vsm = new VideoServiceMatcher();
        $videos = $this->videoRepository->findBy([],['id' => 'DESC']);
        foreach($videos as $videoObj){
            $video = $vsm->parse($videoObj->getLink());
            $link = $video->getEmbedUrl();
            $videoObj->setLink($link);
        }

        return $videos;
    }
}

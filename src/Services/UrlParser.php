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
            foreach ($lesson->getYoutubeLinks() as $link) {
                if ($link->getPath()) {
                    $video = $vsm->parse($link->getPath());
                    $parsed = $video->getEmbedUrl();
                    $link->setPath($parsed);
                }
            }
        }
    }

    public function parseOneLink(Lesson $lesson)
    {
        $vsm = new VideoServiceMatcher();
        foreach($lesson->getYoutubeLinks() as $item) {
            $video = $vsm->parse($item->getPath());
            $link = $video->getEmbedUrl();
            $item->setPath($link);
        }
    }

    public function parseUrl($teacher) :array
    {
        $vsm = new VideoServiceMatcher();
        $videos = $this->videoRepository->findBy(['teacher'=> $teacher],['id' => 'DESC']);
        foreach($videos as $videoObj){
            $video = $vsm->parse($videoObj->getLink());
            $link = $video->getEmbedUrl();
            $videoObj->setLink($link);
        }

        return $videos;
    }
}

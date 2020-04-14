<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-04-13
 * Time: 20:43
 */

namespace App\Controller;


use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends  AbstractController
{
    /**
     * @Route("/admin/results/{year}/{month}", name="generate_results", methods="GET")
     */
    public function generateAction($year,$month, LessonRepository $lessonRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $monthToshow ='';
        switch($month) {
            case ('January');
                $monthToshow = 'Январь';
                break;
            case ('February');
                $monthToshow = 'Февраль';
                break;
            case ('March');
                $monthToshow = 'Март';
                break;
            case ('April');
                $monthToshow = 'Апрель';
                break;
            case ('May');
                $monthToshow = 'Май';
                break;
            case ('June');
                $monthToshow = 'Июнь';
                break;
            case ('July');
                $monthToshow = 'Июль';
                break;
            case ('August');
                $monthToshow = 'Август';
                break;
            case ('September');
                $monthToshow = 'Сентябрь';
                break;
            case ('October');
                $monthToshow = 'Октябрь';
                break;
            case ('November');
                $monthToshow = 'Ноябрь';
                break;
            case ('December');
                $monthToshow = 'Декабрь';
                break;
        }

            // Retrieve the HTML generated in our twig file
        $html = $this->renderView('ResultsController/index.html.twig', [
            'data' => $lessonRepository->getLessonsForResults($year,$month),
            'year' => $year,
            'month'=> $monthToshow
        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream('отчет'.$year.$monthToshow, [
            'Attachment' => true
        ]);
        die();
    }

    /**
     * @Route("/admin/results_dates", name="dates_results", methods="GET")
     */
    public function getAvailableDatesAction()
    {
        $results = $this->getDoctrine()->getRepository(Lesson::class)->getAvailableDatesForResults();

        return $this->render('ResultsController/dates.html.twig',[
           'dates'=> $results
        ]);
    }
}

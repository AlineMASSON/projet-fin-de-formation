<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Repository\CoachRepository;
use App\Repository\ReviewRepository;
use App\Repository\TrainingRepository;
use App\Repository\TriathleteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * display the home page of back office
     * 
     * @Route("/back/", name="app_back_main", methods={"GET"})
     */
    public function index(ReviewRepository $reviewRepository, CoachRepository $coachRepository, TriathleteRepository $triathleteRepository,TrainingRepository $trainingRepository): Response
    {
        $reviews = $reviewRepository->find3LastReviewBackOffice();
        $coachs = $coachRepository->find3LastCoachBackOffice();
        $trainings = $trainingRepository->find3LastTrainingBackOffice();
        $triathletes = $triathleteRepository->find3LastTriathleteBackOffice();  
        return $this->render('back/main/index.html.twig', [
            'reviews' => $reviews,
            'coachs' => $coachs,
            'trainings' => $trainings,
            'triathletes' => $triathletes,
        ]);
    }
}

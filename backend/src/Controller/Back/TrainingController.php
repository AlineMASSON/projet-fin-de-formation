<?php

namespace App\Controller\Back;

use App\Entity\Training;
use App\Form\TrainingType;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/training")
 */
class TrainingController extends AbstractController
{
    /**
     * display the list of the trainings
     * 
     * @Route("/", name="app_back_training_index", methods={"GET"})
     */
    public function index(TrainingRepository $trainingRepository): Response
    {
        return $this->render('back/training/index.html.twig', [
            'trainings' => $trainingRepository->findAll(),
        ]);
    }

    /**
     * diplay the informations of the training
     * 
     * @Route("/{id}", name="app_back_training_show", methods={"GET"})
     */
    public function show(Training $training): Response
    {
        return $this->render('back/training/show.html.twig', [
            'training' => $training,
        ]);
    }

    /**
     * delete a training
     * 
     * @Route("/{id}", name="app_back_training_delete", methods={"POST"})
     */
    public function delete(Request $request, Training $training, TrainingRepository $trainingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$training->getId(), $request->request->get('_token'))) {
            $trainingRepository->remove($training, true);
        }

        $this->addFlash('success', 'Entraînement supprimé');

        return $this->redirectToRoute('app_back_training_index', [], Response::HTTP_SEE_OTHER);
    }
}

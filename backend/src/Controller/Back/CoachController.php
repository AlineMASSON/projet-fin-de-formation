<?php

namespace App\Controller\Back;

use App\Entity\Coach;
use App\Form\UserType;
use App\Form\CoachType;
use App\Repository\UserRepository;
use App\Repository\CoachRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/coach")
 */
class CoachController extends AbstractController
{
    /**
     * display the list of the coachs
     * 
     * @Route("/", name="app_back_coach_index", methods={"GET"})
     */
    public function index(CoachRepository $coachRepository): Response
    {
        return $this->render('back/coach/index.html.twig', [
            'coaches' => $coachRepository->findAll(),
        ]);
    }

    /**
     * display the informations about a coach
     * 
     * @Route("/{id}", name="app_back_coach_show", methods={"GET"})
     */
    public function show(Coach $coach): Response
    {
        return $this->render('back/coach/show.html.twig', [
            'coach' => $coach,
        ]);
    }

    /**
     * modify a coach
     * 
     * @Route("/{id}/edit", name="app_back_coach_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,Coach $coach, CoachRepository $coachRepository, UserRepository $userRepository): Response
    {
        $formC = $this->createForm(CoachType::class, $coach);
        $formC->handleRequest($request);

        $user= $coach->getUser();
        $formU = $this->createForm(UserType::class, $user);
        $formU->handleRequest($request);
        
        if ($formU->isSubmitted() && $formU->isValid()) {
            $userRepository->add($user, true);

            $this->addFlash('success', 'Coach modifié');

            return $this->redirectToRoute('app_back_coach_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($formC->isSubmitted() && $formC->isValid()) {
            $coachRepository->add($coach, true);

            $this->addFlash('success', 'Coach modifié');

            return $this->redirectToRoute('app_back_coach_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('back/coach/edit.html.twig', [
            'coach' => $coach,
            'formC' => $formC,
            'user' => $user,
            'formU' => $formU
        ]);
    }

    /**
     * delete a coach
     * 
     * @Route("/{id}", name="app_back_coach_delete", methods={"POST"})
     */
    public function delete(Request $request, Coach $coach, CoachRepository $coachRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coach->getId(), $request->request->get('_token'))) {
            $coachRepository->remove($coach, true);
        }

        $this->addFlash('success', 'Coach supprimé');

        return $this->redirectToRoute('app_back_coach_index', [], Response::HTTP_SEE_OTHER);
    }
}

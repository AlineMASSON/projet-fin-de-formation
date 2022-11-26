<?php

namespace App\Controller\Back;

use App\Form\UserType;
use App\Entity\Triathlete;
use App\Form\TriathleteType;
use App\Repository\UserRepository;
use App\Repository\TriathleteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back/triathlete")
 */
class TriathleteController extends AbstractController
{
    /**
     * display the list of the triathletes
     *  
     * @Route("/", name="app_back_triathlete_index", methods={"GET"})
     */
    public function index(TriathleteRepository $triathleteRepository): Response
    {
        return $this->render('back/triathlete/index.html.twig', [
            'triathletes' => $triathleteRepository->findAll(),
        ]);
    }

    /**
     * display the informations of the triathlete
     * 
     * @Route("/{id}", name="app_back_triathlete_show", methods={"GET"})
     */
    public function show(Triathlete $triathlete): Response
    {
        return $this->render('back/triathlete/show.html.twig', [
            'triathlete' => $triathlete,
        ]);
    }

    /**
     * modify a triathlete
     * 
     * @Route("/{id}/edit", name="app_back_triathlete_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Triathlete $triathlete, TriathleteRepository $triathleteRepository, UserRepository $userRepository): Response
    {
        $form = $this->createForm(TriathleteType::class, $triathlete);
        $form->handleRequest($request);
        
        $user= $triathlete->getUser();
        $formU = $this->createForm(UserType::class, $user);
        $formU->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $triathlete = $form->getData();
            $triathleteRepository->add($triathlete, true);

            $this->addFlash('success', 'Triathlète modifié');

            return $this->redirectToRoute('app_back_triathlete_index', [], Response::HTTP_SEE_OTHER);

        } 
        
        if ($formU->isSubmitted() && $formU->isValid() ){
            $user = $formU->getData();
            $userRepository->add($user, true);

            $this->addFlash('success', 'Triathlète modifié');

            return $this->redirectToRoute('app_back_triathlete_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/triathlete/edit.html.twig', [
            'triathlete' => $triathlete,
            'form' => $form,
            'user' => $user,
            'formU' => $formU,
        ]);
    }

    /**
     * delete a triathlete
     * 
     * @Route("/{id}", name="app_back_triathlete_delete", methods={"POST"})
     */
    public function delete(Request $request, Triathlete $triathlete, TriathleteRepository $triathleteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$triathlete->getId(), $request->request->get('_token'))) {
            $triathleteRepository->remove($triathlete, true);
        }

        $this->addFlash('success', 'Triathlète supprimé');

        return $this->redirectToRoute('app_back_triathlete_index', [], Response::HTTP_SEE_OTHER);
    }
}

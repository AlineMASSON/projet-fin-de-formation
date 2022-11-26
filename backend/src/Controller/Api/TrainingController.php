<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Training;
use App\Repository\CoachRepository;
use App\Repository\TrainingRepository;
use App\Repository\TriathleteRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CollaborationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrainingController extends AbstractController
{
    /**
     * get trainings to display
     * 
     * @Route("api/trainings/{id}", name="app_api_trainings_get_item", methods={"GET"})
     * 
     * @param Training $training the training to display
     */
    public function getTrainingItem(Training $training): JsonResponse
    {
        // dump($training);

        return $this->json(
            $training,
            Response::HTTP_OK,
            [],
            ['groups' => 'app_api_trainings_get_item']);
    }

    /**
     * create a training
     *
     * @Route("/api/trainings", name="app_api_trainings_post_item", methods={"POST"})
     */
    public function postTrainingItem(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator, TriathleteRepository $triathleteRepository, CollaborationRepository $collaborationRepository,CoachRepository $coachRepository) 
    {
        $jsonContent = $request->getContent();

        $id_tri = json_encode(json_decode($jsonContent)->triathlete);

        $training = $serializer->deserialize($jsonContent, Training::class, 'json');

        $user = $this->getUser();
        assert($user instanceof User);
       
        if(2 === $user->getProfile()){
            $coach = $coachRepository->findOneby(['user' => $user->getId()]);
            $collab = $collaborationRepository->findOneby(['sport' => $training->getSport(), 'coach' => $coach->getId(),'triathlete' => $id_tri]);
       
            if(!$collab){
                return $this->json(['message' => 'Vous n\'avez aucune collaboration pour ce sport avec ce triathlète.'], Response::HTTP_FORBIDDEN);
            }
        }

        $triathlete  = $triathleteRepository->findOneBy(['id' => $id_tri]);
        $training->setTriathlete($triathlete);
        $training->setUser($user);

        $errors = $validator->validate($training);

        if (count($errors) > 0) {           
            $errorsClean = [];

            /** @var ConstraintViolation $error the error */
            foreach($errors as $error) {
                $errorsClean[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->json([
                'errors' => $errorsClean
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $manager = $doctrine->getManager();
        $manager->persist($training);
        $manager->flush();

        return $this->json(
            [
                'message' => 'Votre entraînement a bien été ajouté.',
                $training,
            ],
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl('app_api_trainings_get_item', [
                    'id' => $training->getId()
                ])
            ],
            ['groups' => 'app_api_trainings_get_item']
        );
    }

    /**
     * modify a training
     *
     * @Route("/api/trainings/{id}", name="app_api_trainings_patch_item", methods={"PATCH"})
     * 
     */
    public function patchTrainingItem(Training $training,Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator, CollaborationRepository $collaborationRepository,CoachRepository $coachRepository) 
    {
        $jsonContent = $request->getContent();
   
        $id_tri = $training->getTriathlete()->getId();
       
        $serializer->deserialize(
            $jsonContent,
            Training::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $training]
        );
   
        $user = $this->getUser();
        assert($user instanceof User);
      
        if(2 === $user->getProfile()){
            $coach = $coachRepository->findOneby(['user' => $user->getId()]);
            $collab = $collaborationRepository->findOneby(['sport' => $training->getSport(), 'coach' => $coach->getId(),'triathlete' => $id_tri]);
       
            if(!$collab){
                return $this->json(['message' => 'Vous n\'avez aucune collaboration pour ce sport avec ce triathlète.'], Response::HTTP_FORBIDDEN);
            }
        }

        $errors = $validator->validate($training);

        if (count($errors) > 0) {           
            $errorsClean = [];

            /** @var ConstraintViolation $error the error */
            foreach($errors as $error) {
                $errorsClean[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->json([
                'errors' => $errorsClean
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json(
            [
                'message' => 'Votre entraînement a bien été modifié.',
                $training,
            ],
            Response::HTTP_OK,
            [
                'Location' => $this->generateUrl('app_api_trainings_get_item', [
                    'id' => $training->getId()
                ])
            ],
            ['groups' => 'app_api_trainings_get_item']
        );
    }

    /**
     * delete a training
     * 
     * @Route("api/trainings/{id}", name="app_api_trainings_delete_item", methods={"DELETE"})
     * 
     * @param Training $training the training to delete
     */
    public function deleteTrainingItem(Training $training = null, TrainingRepository $trainingRepository)
    {
        $author = $training->getUser();
        $user = $this->getUser();

        if (null === $training) {
            return $this->json(['message' => 'Entrainement inexistant.'], Response::HTTP_NOT_FOUND);
        }

        if($author !== $user){
            return $this->json(['message' => "Vous n'êtes pas l'auteur de cet entrainement."], Response::HTTP_FORBIDDEN);
        }
        
        if($training->isIsValidated()){
            return $this->json(['message' => "Cet entrainement est déjà effectué, vous ne pouvez pas le supprimer"], Response::HTTP_FORBIDDEN);
        }

        $trainingRepository->remove($training, true);

        return $this->json(['message' => 'Votre entraînement a bien été supprimé.'], Response::HTTP_OK);
    }
}

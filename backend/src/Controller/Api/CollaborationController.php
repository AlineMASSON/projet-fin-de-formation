<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Collaboration;
use App\Entity\Triathlete;
use App\Repository\CoachRepository;
use App\Repository\TriathleteRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CollaborationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CollaborationController extends AbstractController
{
    /**
     * create a collaboration
     * 
     * @Route("/api/collaborations", name="app_api_collaboration_post_item", methods={"POST"})
     */
    public function postCollaborationItem(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator, TriathleteRepository $triathleteRepository, CollaborationRepository $collaborationRepository,CoachRepository $coachRepository) 
    {
        $jsonContent = $request->getContent();
        
        $user = $this->getUser();
        assert($user instanceof User);
        
        if(2 === $user->getProfile()){
            return $this->json(['message' => 'Vous n\'avez aucune collaboration pour ce sport avec ce triathlète.'], Response::HTTP_FORBIDDEN);
        }

        $tri_id = json_encode(json_decode($jsonContent)->triathlete);
        $coach_id = json_encode(json_decode($jsonContent)->coach);
        $sport = json_decode($jsonContent)->sport;
        
        $triathlete = $triathleteRepository->find($tri_id);
        $coach = $coachRepository->find($coach_id);
        
        if (!$coach->isIsAvailable()) {
            return $this->json(['message' => 'Ce coach n\'est pas disponible pour une nouvelle collaboration.'], Response::HTTP_FORBIDDEN);
        }

        if ($sport === 'Natation') {
            if (!$coach->isSwim()) {
                return $this->json(['message' => 'Ce coach ne dispense pas d\'entraînement pour ce sport.'], Response::HTTP_FORBIDDEN);
            }
        }

        if ($sport === 'Cyclisme') {
            if (!$coach->isBike()) {
                return $this->json(['message' => 'Ce coach ne dispense pas d\'entraînement pour ce sport.'], Response::HTTP_FORBIDDEN);
            }
        }

        if ($sport === 'Course à pied') {
            if (!$coach->isRun()) {
                return $this->json(['message' => 'Ce coach ne dispense pas d\'entraînement pour ce sport.'], Response::HTTP_FORBIDDEN);
            }
        }
        
        $collaboration = $serializer->deserialize($jsonContent, Collaboration::class, 'json');
        $collaboration->setTriathlete($triathlete);
        $collaboration->setCoach($coach);
        $col = $collaborationRepository->findOneby(['coach' => $coach_id,'triathlete' => $tri_id,'sport' => $sport]);
       
        if(null !== $col ){
            return $this->json(['message' => 'Vous avez déjà soumis une collaboration pour ce sport à ce coach.'], Response::HTTP_FORBIDDEN);
        }
        
        $errors = $validator->validate($collaboration);

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
        $manager->persist($collaboration);
        $manager->flush();

        return $this->json(['message' => 'Votre demande de collaboration a été soumise.'],Response::HTTP_CREATED
        );
    }

    /**
     * patch a collaboration
     * 
     * @Route("/api/collaborations/{id}", name="app_api_collaboration_patch_item", methods={"PATCH"})
     */
    public function patchCollaborationItem(Collaboration $collaboration = null, Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator) 
    {
        if (null === $collaboration) {
            throw $this->createNotFoundException('Collaboration non trouvée');
        }

        $jsonContent = $request->getContent();

        $user = $this->getUser();
        assert($user instanceof User);

        $coach = $collaboration->getCoach();

        if ($user->getId() !== $coach->getUser()->getId()) {
            return $this->json(['message' => 'Vous n\'êtes pas le coach concerné par cette collaboration.'], Response::HTTP_FORBIDDEN);
        }

        $sport = json_decode($jsonContent)->sport;

        if ($sport !== $collaboration->getSport()) {
            return $this->json(['message' => 'Ce sport ne correspond pas à celui demandé dans cette collaboration.'], Response::HTTP_FORBIDDEN);
        }

        $id = $collaboration->getId();
        $collaboration->setApproved(true);

        $serializer->deserialize(
            $id,
            Collaboration::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $collaboration]
        );

        $errors = $validator->validate([$collaboration]);
        if (count($errors) > 0) {

            $errorsClean = [];

            /** @var ConstraintViolation $error L'erreur */
            foreach ($errors as $error) {
                $errorsClean[$error->getPropertyPath()][] = $error->getMessage();
            }

            return $this->json([
                'errors' => $errorsClean
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json(['message' => 'Votre collaboration a bien été approuvée'], Response::HTTP_OK);
    }

    /**
     * delete the collaboration
     * 
     * @Route("api/collaborations/{id}", name="app_api_collaborations_delete_item", methods={"DELETE"})
     * 
     * @param Collaboration $collaboration the collaboration to delete
     */
    public function deleteCollaborationItem(Collaboration $collaboration = null, CollaborationRepository $collaborationRepository)
    {
        if (null === $collaboration) {
            return $this->json(['message' => 'Collaboration inexistante.'], Response::HTTP_NOT_FOUND);
        }

        $user = $this->getUser();
        assert($user instanceof User);

        if (2 === $user->getProfile()) {
            $coach = $collaboration->getCoach();
            if ($coach->getUser() !== $user) {
                return $this->json(['message' => 'Vous n\'êtes pas le coach concerné par cette collaboration.'], Response::HTTP_FORBIDDEN);
            }
        }

        if (1 === $user->getProfile()) {
            $triathlete = $collaboration->getTriathlete();
            if ($triathlete->getUser() !== $user) {
                return $this->json(['message' => 'Vous n\'êtes pas le triathlète concerné par cette collaboration.'], Response::HTTP_FORBIDDEN);
            }
        }

        $collaborationRepository->remove($collaboration, true);

        return $this->json(['message' => 'Votre collaboration a bien été supprimée.'], Response::HTTP_OK);
    }
}

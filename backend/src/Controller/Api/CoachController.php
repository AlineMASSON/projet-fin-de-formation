<?php

namespace App\Controller\Api;

use App\Entity\Coach;
use App\Entity\User;
use App\Repository\CoachRepository;
use App\Repository\CollaborationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CoachController extends AbstractController
{
    /**
     * get informations about the coach to display
     * 
     * @Route("/api/coach/{id}", name="app_api_coachs_get_item", methods={"GET"})
     * 
     * @param Coach $coach the coach to display
     */
    public function getCoachItem(Coach $coach): JsonResponse
    {
        
        return $this->json(
            $coach,
            Response::HTTP_OK,
            [],
            ['groups' => 'app_api_coachs_get_item']);
    }
    /**
     * get all the coachs
     * 
     * @Route("api/coachs", name="app_api_coachs_get_collection", methods={"GET"})
     * 
     */
    public function getcoachCollection(CoachRepository $coachRepository): JsonResponse
    {
        $coach = $coachRepository->findBy(['isAvailable' => 1]);
        return $this->json(
            $coach,
            Response::HTTP_OK,
            [],
            ['groups' => 'app_api_coachs_get_collection']);
    }
    /**
     * patch informations about the coach
     *
     * @Route("api/coachs/{id}", name="app_api_coachs_patch_item", methods={"PATCH"})
     * 
     * @param Coach $coach the coach to patch
     */
    public function patchCoachItem(Coach $coach = null, Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        
        if (null === $coach) {
            throw $this->createNotFoundException('Coach non trouvé');
        }
        
        $user = $this->getUser();
        assert($user instanceof User);
        
        $this->denyAccessUnlessGranted('USER_EDIT', $coach);
        
        
        $jsonContent = $request->getContent();
        dump($jsonContent);
        $coachContent = json_encode(json_decode($jsonContent)->coach);

        if (isset(json_decode($jsonContent)->password)) {
            $user->setPassword(password_hash(json_decode($jsonContent)->password, PASSWORD_DEFAULT));
        }
       
        $serializer->deserialize(
            $jsonContent,
            User::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $user]
        );
        

        
        $serializer->deserialize(
            $coachContent,
            Coach::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $coach]
        );

        
        $errors = $validator->validate([$user, $coach]);

        
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
        
        return $this->json(['message' => 'Votre profil a bien été modifié'], Response::HTTP_OK);
    }


    /**
     * delete the coach
     * 
     * @Route("/api/coach/{id}", name="app_api_coachs_delete_item", methods={"DELETE"})
     * 
     * @param Coach $coach the coach to delete
     */
    public function deleteCoachItem(Coach $coach, CoachRepository $coachRepository): JsonResponse
    {
        $user = $this->getUser();

        if (null === $coach) {
            return $this->json(['message' => 'Utilisateur coach inexistant.'], Response::HTTP_NOT_FOUND);
        }

        if($coach->getUser() !== $user){
            return $this->json(['message' => "Ce compte ne vous appartient pas."], Response::HTTP_FORBIDDEN);
        }

        $coachRepository->remove($coach, true);

        return $this->json(['message' => 'Votre profil a bien été supprimé.'], Response::HTTP_OK);
    }
}

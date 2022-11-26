<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Coach;
use App\Entity\Triathlete;
use App\Service\PictureUser;
use App\Repository\TrainingRepository;
use App\Repository\TriathleteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TriathleteController extends AbstractController
{
    /**
     * get all the trainings about a triathlete
     * 
     * @Route("api/triathletes/{id}/trainings", name="app_api_trainings_triathletes_collection", methods={"GET"})
     * 
     * @param Triathlete $triathlete the triathlete that i want the trainings
     */
    public function getTrainingsbyTriathleteCollection(Triathlete $triathlete,TrainingRepository $trainingRepository): JsonResponse
    {
        $trainings = $trainingRepository->findBy(['triathlete' => $triathlete]);
        return $this->json(
            $trainings,
            Response::HTTP_OK,
            [],
            ['groups' => 'app_api_trainings_triathletes_collection']);
    }
    /**
     * get all the triathletes by coach
     * 
     * @Route("api/coachs/{id}/triathletes", name="app_api_get_triathletes_by_coach", methods={"GET"})
     * 
     * @param Coach $coach the coach that i want the triathletes
     */
    public function getTriathletesbycoach(Coach $coach): JsonResponse
    {
        return $this->json(
            $coach,
            Response::HTTP_OK,
            [],
            ['groups' => 'app_api_get_triathletes_by_coach']);
    }
    /**
     * get informations about the triathlete to display
     * 
     * @Route("api/triathletes/{id}", name="app_api_triathletes_get_item", methods={"GET"})
     * 
     * @param Triathlete $triathlete the triathlete to display
     */
    public function getTriathleteItem(Triathlete $triathlete): JsonResponse
    {
        return $this->json(
            $triathlete,
            Response::HTTP_OK,
            [],
            ['groups' => 'app_api_triathletes_get_item']);
    }

    /**
     * patch informations about the triathlete
     *
     * @Route("api/triathletes/{id}", name="app_api_triathletes_patch_item", methods={"PATCH"})
     * 
     * @param Triathlete $triathlete the triathlete to patch
     */
    public function patchTriathleteItem(PictureUser $pictureUser, Triathlete $triathlete = null, Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        if (null === $triathlete) {
            throw $this->createNotFoundException('Triathlète non trouvé');
        }

        $user = $this->getUser();
        assert($user instanceof User);
        $this->denyAccessUnlessGranted('TRIATHLETE_EDIT', $triathlete);

        $jsonContent = $request->getContent();
        
        $triContent = json_encode(json_decode($jsonContent)->triathlete);
        
        $serializer->deserialize(
            $jsonContent,
            User::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $user]
        );
        
        if (isset(json_decode($jsonContent)->password)) {
            $user->setPassword(password_hash(json_decode($jsonContent)->password, PASSWORD_DEFAULT));
        }
        if ('src/assets/avatar/user.svg' === $user->getPicture() || $user->getPicture() === '') {
            if (1 === $user->getGender()) {
                $user->setPicture($pictureUser->getpictureman());
            }
            if (2 === $user->getGender()) {
                $user->setPicture($pictureUser->getpicturewoman());
            }
        }

        $serializer->deserialize(
            $triContent,
            Triathlete::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $triathlete]
        );
        
        $errors = $validator->validate([$user, $triathlete]);

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
     * delete the triathlete
     * 
     * @Route("api/triathletes/{id}", name="app_api_triathletes_delete_item", methods={"DELETE"})
     * 
     * @param Triathlete $triathlete the triathlete to delete
     */
    public function deleteTriathleteItem(Triathlete $triathlete = null, TriathleteRepository $triathleteRepository)
    {
        // TODO vérifier que le user est bien le triathlète pour qu'il puisse supprimer son compte Voter ?
        // si le triathlete n'est pas trouvé.
        if (null === $triathlete) {
            return $this->json(['message' => 'Utilisateur triathlete inexistant.'], Response::HTTP_NOT_FOUND);
        }

        $triathleteRepository->remove($triathlete, true);

        return $this->json(['message' => 'Votre profil a bien été supprimé.'], Response::HTTP_OK);
    }
}

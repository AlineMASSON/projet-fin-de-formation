<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Review;
use App\Entity\Training;
use App\Repository\CoachRepository;
use App\Repository\TriathleteRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CollaborationRepository;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    /**
     *  create a review
     * 
     * @Route("/api/trainings/{id}/review", name="app_api_reviews_post_item" , methods={"POST"})
     * 
     * @param Review $review the review 
     */
    public function postReviewItem(Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator, Training $training, CollaborationRepository $collaborationRepository,CoachRepository $coachRepository): JsonResponse
    {
        $jsonContent = $request->getContent();
        $id_tri= $training->getTriathlete()->getId();
        
        $user = $this->getUser();
        assert($user instanceof User);
        
        if(2 === $user->getProfile()){
            $coach = $coachRepository->findOneby(['user' => $user->getId()]);
            $collab = $collaborationRepository->findOneby(['coach' => $coach->getId(),'triathlete' => $id_tri]);
       
            if(!$collab){
                return $this->json(['message' => 'Vous n\'avez aucune collaboration pour ce sport avec ce triathlète.'], Response::HTTP_FORBIDDEN);
            }
        }

        if ( 1 === $user->getProfile()) {
            $id_user_tri= $training->getTriathlete()->getUser()->getId();
            if ($id_user_tri !== $user->getId()) {
                return $this->json(['message' => 'Vous n\'êtes pas concerné par cet entrainement.'], Response::HTTP_FORBIDDEN);
            }
        }
 
        $review = $serializer->deserialize($jsonContent, Review::class, 'json');
        $review->setUser($user);
        $review->setTraining($training);
        
        $errors = $validator->validate($review);

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
        $manager->persist($review);
        $manager->flush();

        return $this->json(
            [
                'message' => 'Votre commentaire a bien été ajouté.',
                $review,
            ],
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl('app_api_trainings_get_item', [
                    'id' => $review->getId()
                ])
            ],
            ['groups' => 'app_api_trainings_get_item']
        );
    }
    /**
     * delete a review
     * 
     * @Route("api/reviews/{id}", name="app_api_reviews_delete_item", methods={"DELETE"})
     * 
     * @param Review $review the review to delete
     */
    public function deleteReviewItem(Review $review = null, ReviewRepository $reviewRepository)
    {
        $author = $review->getUser();
        $user = $this->getUser();

        if (null === $review) {
            return $this->json(['message' => 'Commentaire inexistant.'], Response::HTTP_NOT_FOUND);
        }
        
        if($author !== $user){
            return $this->json(['message' => "Vous n'êtes pas l'auteur de ce commentaire."], Response::HTTP_FORBIDDEN);
        }

        $reviewRepository->remove($review, true);

        return $this->json(['message' => 'Votre commentaire a bien été supprimé.'], Response::HTTP_OK);
    }
}

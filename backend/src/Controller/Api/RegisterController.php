<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Coach;
use App\Service\SendMail;
use App\Entity\Triathlete;
use App\Service\SendMailer;
use App\Repository\UserRepository;
use App\Repository\CoachRepository;
use App\Repository\TriathleteRepository;
use App\Service\PictureUser;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{
    /**
     * create a user
     * 
     * @Route("/api/register", name="app_api_register", methods={"POST"})
     */
    public function registerPostItem(SendMail $mail, Request $request, SerializerInterface $serializer, ManagerRegistry $doctrine, ValidatorInterface $validator): JsonResponse
    {
        $jsonContent = $request->getContent();

        $user = $serializer->deserialize($jsonContent, User::class, 'json');
        $user->setPassword(password_hash(json_decode($jsonContent)->password, PASSWORD_DEFAULT));

        $errors = $validator->validate($user);

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
        $manager->persist($user);

        if (2 === $user->getProfile()) {
            $coach = $serializer->deserialize($jsonContent, Coach::class, 'json');  
            $coach->setUser($user);
            $manager = $doctrine->getManager();
            $manager->persist($coach);
        }

        if (1 === $user->getProfile()) {
            $triathlete = $serializer->deserialize($jsonContent, Triathlete::class, 'json');  
            $triathlete->setUser($user);

            $manager = $doctrine->getManager();
            $manager->persist($triathlete);
        }
        
        $manager->flush();
        //$mail->send($user);
        return $this->json(['message' => 'Votre compte a bien été créé.'], Response::HTTP_CREATED);

    }
}

<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
    /**
     * @Route("/api/login", name="app_api_login")
     */
    public function index():JsonResponse {
        $user = $this->getUser();
        assert($user instanceof User);
        
        if(null === $user){
             return $this->json([
                 'message' => 'Identifiants incorrects',
             ], Response::HTTP_UNAUTHORIZED);
        }
        
        return $this->json([
            'user'  => $user->getUserIdentifier(),
        ], Response::HTTP_OK);
    }
}

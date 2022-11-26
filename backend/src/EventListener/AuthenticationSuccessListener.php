<?php

namespace App\EventListener;

use App\Entity\User;
use App\Repository\CoachRepository;
use App\Repository\TriathleteRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener 
{

    private $userRepository;
    private $triathleteRepository;
    private $coachRepository;

    public function __construct(UserRepository $userRepository, TriathleteRepository $triathleteRepository, CoachRepository $coachRepository)
    {
        $this->userRepository = $userRepository;
        $this->triathleteRepository = $triathleteRepository;
        $this->coachRepository = $coachRepository;
    }

    /**
     * add some data in login response to the front
     * 
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }
        $currentUser = $this->userRepository->findByEmail($user->getUserIdentifier());

        if (1 === $currentUser[0]->getProfile()) {
            $triathlete = $this->triathleteRepository->findOneBy(['user' => $currentUser[0]->getId()]);
            $data['triathleteId'] = $triathlete->getId();
        }

        if (2 === $currentUser[0]->getProfile()) {
            $coach = $this->coachRepository->findOneBy(['user' => $currentUser[0]->getId()]);
            $data['coachId'] = $coach->getId();
        }

        $data['email'] = $user->getUserIdentifier();
        $data['firstname'] = $currentUser[0]->getFirstname();
        $data['userId'] = $currentUser[0]->getId();

        $event->setData($data);
    }
}
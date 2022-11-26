<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class SendMail
{
    private $mailer;

    public function __construct( MailerInterface $mailer){
        $this->mailer = $mailer;
    }

    public function send(User $user): bool
    {
        $email = (new TemplatedEmail())
            ->from('admin@uptrain.com')
            ->context([
                'name' => $user->getLastname(),
                'firstname' => $user->getFirstname(),
            ])
            ->to($user->getEmail())
            ->subject('Inscription au Site Uptrain, Votre partenaire d\'entraînement!')
            ->htmlTemplate('emails/signup.html.twig');
        $this->mailer->send($email);
        return true;
    }
}
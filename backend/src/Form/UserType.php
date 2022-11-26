<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname',TextType::class, [
                'label' => 'Nom :',
            ])
            ->add('firstname',TextType::class, [
                'label' => 'Prénom :',
            ])
            ->add('email')
            ->add('roles',ChoiceType::class, [
                'label' => 'Rôles :',
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('profile',null,[
                'label' => 'Profil :',
                'help' => 'La valeur 1 correspond au profile triathlète et la valeur 2 correspond au profile 2.', 
                'help_attr' => [
                    'class' => 'text-dark',
                ]]
            )
            ->add('date_birth', null, [
                'label' => 'Date de naissance :',
                'widget' => 'single_text',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',
            ])
            ->add('picture', TextType::class, [
                'label' => 'Photographie :',
                'help' => 'Url de la photo de profil.', 
                'help_attr' => [
                    'class' => 'text-dark',
                ]
            ])
            ->add('gender',ChoiceType::class, [
                'label' => 'Genre :',
                'choices' => [
                    'Homme' => 1,
                    'Femme' => 2,
                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville de résidence :',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

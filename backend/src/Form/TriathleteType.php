<?php

namespace App\Form;

use App\Entity\Triathlete;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TriathleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('palmares', TextareaType::class, [
                'label' => 'Palmares :',
            ])
            ->add('weight', IntegerType::class, [
                'label' => 'Poids :',
                'help' => 'En kilogrammes.', 
                'help_attr' => [
                    'class' => 'text-dark',
                ]
            ])
            ->add('size', IntegerType::class, [
                'label' => 'Taille :',
                'help' => 'En centimètres.', 
                'help_attr' => [
                    'class' => 'text-dark',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Triathlete::class,
        ]);
    }
}

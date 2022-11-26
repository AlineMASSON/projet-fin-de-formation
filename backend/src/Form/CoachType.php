<?php

namespace App\Form;

use App\Entity\Coach;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CoachType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('swim', CheckboxType::class, [
                'label'    =>  'Natation',
                'required' => false,
            ])
            ->add('bike', CheckboxType::class, [
                'label'    => 'Cyclisme',
                'required' => false,
            ])
            ->add('run', CheckboxType::class, [
                'label'    => 'Course à pied',
                'required' => false,
            ])
            ->add('experience', TextareaType::class, [
                'label' => 'Expérience :',
            ])
            ->add('isAvailable', CheckboxType::class, [
                'label'   => 'Disponibilité',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coach::class,
        ]);
    }
}

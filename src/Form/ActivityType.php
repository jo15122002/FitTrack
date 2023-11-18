<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type d\'activité',
                'choices' => [
                    'Course à pied' => 'course_a_pied',
                    'Cyclisme' => 'cyclisme',
                    'Natation' => 'natation',
                    // Ajoutez d'autres types d'activités au besoin
                ],
                'required' => true,
            ])
            ->add('distance', TextType::class, [
                'label' => 'Distance (en kilomètres)',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Range(['min' => 0]),
                ],
            ])
            ->add('duration', TimeType::class, [
                'label' => 'Durée (hh:mm:ss)',
                'required' => true,
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de l\'activité',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer l\'activité',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Activity', // Assurez-vous que c'est la classe correcte pour votre entité Activity
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Goal;
use App\Entity\WorkoutPlan;
use App\Enum\GoalStatus;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
            ->add('description', TextType::class, [
                'label' => 'Description de l\'objectif',
                // autres options pour le champ 'description'
            ])
            ->add('deadline', DateTimeType::class, [
                'label' => 'Date limite',
                'widget' => 'single_text', // pour avoir un sélecteur de date unique
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut de l\'objectif',
                'choices' => [
                    'A commencer' => GoalStatus::TODO->value,
                    'En cours' => GoalStatus::IN_PROGRESS->value,
                    'Atteint' => GoalStatus::DONE->value,
                    'Échoué' => GoalStatus::FAILED->value,
                    'Annulé' => GoalStatus::CANCELLED->value,
                ],
            ])
            ->add('workoutPlans', EntityType::class, [
                'class' => WorkoutPlan::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('wp')
                        ->where('wp.author = :user')
                        ->setParameter('user', $user);
                },
                'choice_label' => 'description',
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer l\'objectif',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Goal::class,
            'user' => null,
        ]);
    }
}

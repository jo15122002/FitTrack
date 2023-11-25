<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// Autres types de champs nécessaires

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form-control'], // Classe Bootstrap pour le champ
                'label_attr' => ['class' => 'form-label'], // Classe Bootstrap pour l'étiquette
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'], // Classe Bootstrap pour le champ
                'label_attr' => ['class' => 'form-label'], // Classe Bootstrap pour l'étiquette
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'], // Classe Bootstrap pour le bouton
                'label' => 'Enregistrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

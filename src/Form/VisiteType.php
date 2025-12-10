<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type; // Importez Type pour DateTimeType si nécessaire

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', Type\DateTimeType::class, [ // Utilisation de Type\DateTimeType pour la compatibilité
                'widget' => 'single_text',
            ])
            ->add('commentaire')
            ->add('compteRendu')
            ->add('statut')
            ->add('lieu')
            ->add('objectif')
            ->add('remarques')
            // Suppression des relations : 'tuteur', 'edudiant', et 'etdudiant'
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
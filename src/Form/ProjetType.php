<?php

namespace App\Form;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du projet',
                'attr' => ['placeholder' => 'Entrez le titre du projet (min. 5 caractères)', 'class' => 'form-control'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['placeholder' => 'Description du projet...', 'class' => 'form-control', 'rows' => 4],
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    '🔵 En préparation' => Projet::STATUT_EN_PREPARATION,
                    '🟡 En cours' => Projet::STATUT_EN_COURS,
                    '🟢 Terminé' => Projet::STATUT_TERMINE,
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('enseignant', EntityType::class, [
                'class' => Enseignant::class,
                'choice_label' => function (Enseignant $enseignant) {
                    return $enseignant->getNom() . ' (' . $enseignant->getGrade() . ')';
                },
                'label' => 'Enseignant encadrant',
                'placeholder' => 'Sélectionnez un enseignant',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('etudiants', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => function (Etudiant $etudiant) {
                    return $etudiant->getNom() . ' (' . $etudiant->getNiveau() . ')';
                },
                'label' => 'Étudiants participants',
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'form-select', 'size' => 6],
                'help' => 'Maintenez Ctrl pour sélectionner plusieurs étudiants',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}

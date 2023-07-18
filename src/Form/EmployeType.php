<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Employe; // Importation de la classe d'entité Employe
use Symfony\Component\Form\AbstractType; // Importation de la classe AbstractType du composant Form
use Symfony\Component\Form\FormBuilderInterface; // Importation de la classe FormBuilderInterface du composant Form
use Symfony\Component\OptionsResolver\OptionsResolver; // Importation de la classe OptionsResolver du composant Form
use Symfony\Component\Form\Extension\Core\Type\DateType; // Importation de la classe DateType du composant Form (pour le champ date)
use Symfony\Component\Form\Extension\Core\Type\TextType; // Importation de la classe TextType du composant Form (pour le champ texte)
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Importation de la classe SubmitType du composant Form (pour le bouton de soumission)

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Ajout d'un champ 'prenom' de type TextType (champ texte)
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            // Ajout d'un champ 'nom' de type TextType (champ texte)
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            // Ajout d'un champ 'dateNaissance' de type DateType (champ de date)
            // 'single_text' est utilisé pour n'afficher que la date (sans l'heure)
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text', 
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            // Ajout d'un champ 'dateEmbauche' de type DateType (champ de date)
            // 'single_text' est utilisé pour n'afficher que la date (sans l'heure)
            ->add('dateEmbauche', DateType::class, [
                'widget' => 'single_text', 
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            // Ajout d'un champ 'ville' de type TextType (champ texte)
            ->add('ville', TextType::class, [
                // Mettre la ville facultative
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            // Ajout d'un bouton de soumission avec le label 'Valider'
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configuration des options du formulaire
        $resolver->setDefaults([
            'data_class' => Employe::class, // L'entité Employe associée au formulaire
        ]);
    }
}

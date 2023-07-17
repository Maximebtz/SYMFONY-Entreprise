<?php 

namespace App\Form;

use App\Entity\Entreprise; // Importation de la classe d'entité Entreprise
use Symfony\Component\Form\AbstractType; // Importation de la classe AbstractType du composant Form
use Symfony\Component\Form\FormBuilderInterface; // Importation de la classe FormBuilderInterface du composant Form
use Symfony\Component\OptionsResolver\OptionsResolver; // Importation de la classe OptionsResolver du composant Form
use Symfony\Component\Form\Extension\Core\Type\DateType; // Importation de la classe DateType du composant Form (pour le champ date)
use Symfony\Component\Form\Extension\Core\Type\TextType; // Importation de la classe TextType du composant Form (pour le champ texte)
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Importation de la classe SubmitType du composant Form (pour le bouton de soumission)

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Ajout d'un champ 'raisonSociale' de type TextType (champ texte)
            ->add('raisonSociale', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]])
            // Ajout d'un champ 'dateCreation' de type DateType (champ de date)
            // 'single_text' est utilisé pour n'afficher que la date (sans l'heure)
            ->add('dateCreation', DateType::class, [
                'widget' => 'single_text', 
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            // Ajout d'un champ 'adresse' de type TextType (champ texte)
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]])
            // Ajout d'un champ 'cp' de type TextType (champ texte)
            ->add('cp', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]])
            // Ajout d'un champ 'ville' de type TextType (champ texte)
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]])
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
            'data_class' => Entreprise::class, // L'entité Entreprise associée au formulaire
        ]);
    }
}

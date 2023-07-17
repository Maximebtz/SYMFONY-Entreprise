<?php

namespace App\Controller;

use App\Entity\Entreprise; // Importation de la classe d'entité Entreprise
use App\Form\EntrepriseType; // Importation de la classe de formulaire EntrepriseType
use App\Repository\EntrepriseRepository; // Importation de la classe de repository EntrepriseRepository
use Doctrine\ORM\EntityManagerInterface; // Importation de la classe EntityManagerInterface
use Symfony\Component\HttpFoundation\Request; // Importation de la classe Request du composant HttpFoundation
use Symfony\Component\HttpFoundation\Response; // Importation de la classe Response du composant HttpFoundation
use Symfony\Component\Routing\Annotation\Route; // Importation de l'annotation Route pour définir les routes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importation de la classe de contrôleur de base

class EntrepriseController extends AbstractController
{
    // Méthode pour afficher la liste des entreprises
    #[Route('/entreprise', name: 'app_entreprise')] // Définition de la route et du nom de la route
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        // Utilisation du repository pour récupérer la liste des entreprises triées par raison sociale
        $entreprises = $entrepriseRepository->findBy([], ["raisonSociale" => "ASC"]);

        // Rendu du template 'entreprise/index.html.twig' en passant les entreprises à afficher
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
        ]);
    }

    // Méthode pour créer une nouvelle entreprise
    #[Route('/entreprise/new', name: 'new_entreprise')] // Définition de la route et du nom de la route
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de l'entité Entreprise
        $entreprise = new Entreprise();
        // ...

        // Création d'un formulaire basé sur EntrepriseType et associé à l'entité Entreprise
        $form = $this->createForm(EntrepriseType::class, $entreprise);

        // Traite la requête HTTP entrante avec le formulaire
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données du formulaire
            $entreprise = $form->getData();

            // Persiste les données dans la base de données via l'entityManager
            $entityManager->persist($entreprise);
            $entityManager->flush();

            // Redirige vers une autre page (remplacez 'app_entreprise' par la route de destination souhaitée)
            return $this->redirectToRoute('app_entreprise');
        }

        // Rendu du template 'entreprise/new.html.twig' en passant le formulaire à afficher
        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
        ]);
    }

    // Méthode pour afficher les détails d'une entreprise
    #[Route('/entreprise/{id}', name: 'show_entreprise')] // Définition de la route avec un paramètre 'id' et du nom de la route
    public function show(Entreprise $entreprise): Response
    {
        // Rendu du template 'entreprise/show.html.twig' en passant l'entreprise à afficher
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise
        ]);
    }
}

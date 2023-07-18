<?php 

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EmployeType; // Importation de la classe de formulaire EmployeType
use App\Repository\EmployeRepository; // Importation de la classe de repository EmployeRepository
use Symfony\Component\Routing\Annotation\Route; // Importation de l'annotation Route pour définir les routes
use Symfony\Component\HttpFoundation\Request; // Importation de la classe Request du composant HttpFoundation
use Symfony\Component\HttpFoundation\Response; // Importation de la classe Response du composant HttpFoundation
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Importation de la classe de contrôleur de base

class EmployeController extends AbstractController
{
    // Méthode pour afficher la liste des employés
    #[Route('/employe', name: 'app_employe')] // Définition de la route et du nom de la route
    public function index(EmployeRepository $employeRepository): Response
    {
        // Utilisation du repository pour récupérer la liste de tous les employés
        $employes = $employeRepository->findAll();

        // Rendu du template 'employe/index.html.twig' en passant les employés à afficher
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
        ]);
    }

    // Méthode pour créer un nouvel employé
    #[Route('/employe/new', name: 'new_employe')] // Définition de la route avec un paramètre 'id' et du nom de la route
    #[Route('/employe/{id}/edit}', name: 'edit_employe')] // Définition de la route avec un paramètre 'id' et du nom de la route
    public function new_edit(Employe $employe = null, Request $request, EntityManagerInterface $entityManager): Response
    {

        if(!$employe){// Création d'une nouvelle instance de l'entité Employe
            $employe = new Employe();
        }

        // Création d'un formulaire basé sur EmployeType et associé à l'entité Employe
        $form = $this->createForm(EmployeType::class, $employe);

        // Traite la requête HTTP entrante avec le formulaire
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données du formulaire
            $employe = $form->getData();

            // Persiste les données dans la base de données via l'entityManager
            $entityManager->persist($employe);
            $entityManager->flush();

            // Redirige vers une autre page (remplacez 'app_employe' par la route de destination souhaitée)
            return $this->redirectToRoute('app_employe');
        }

        // Rendu du template 'employe/new.html.twig' en passant le formulaire à afficher
        return $this->render('employe/new.html.twig', [
            'formAddEmploye' => $form,
            'edit' => $employe->getId()
        ]);
    }

    // Méthode pour afficher les suppr un employé
    #[Route('/employe/{id}/delete', name: 'delete_employe')] // Définition de la route avec un paramètre 'id' et du nom de la route
    public function delete(Employe $employe, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($employe);
        $entityManager->flush();

        return $this->redirectToRoute('app_employe');
    }

    // Méthode pour afficher les détails d'un employé
    #[Route('/employe/{id}', name: 'show_employe')] // Définition de la route avec un paramètre 'id' et du nom de la route
    public function show(Employe $employe): Response
    {
        // Rendu du template 'employe/show.html.twig' en passant l'employé à afficher
        return $this->render('employe/show.html.twig', [
            'employe' => $employe
        ]);
    }
}

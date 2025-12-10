<?php

namespace App\Controller;

use App\Entity\Visite;
use App\Entity\Etudiant; // Nécessaire pour l'injection de l'étudiant
use App\Form\VisiteType;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException; 
use Symfony\Component\Security\Http\Attribute\IsGranted;

// Route imbriquée sous l'étudiant (par son ID)
#[Route('/etudiant/{id_etudiant}/visite')]
#[IsGranted('ROLE_USER')] // Sécurité globale
final class VisiteController extends AbstractController
{
    /**
     * Récupère l'étudiant basé sur l'ID de la route et vérifie la propriété.
     * @throws AccessDeniedException si l'étudiant n'appartient pas à l'utilisateur connecté.
     */
    private function getEtudiantAndCheckAccess(Etudiant $etudiant): Etudiant
    {
        // VÉRIFICATION DE PROPRIÉTÉ
        if ($etudiant->getTuteur() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Cet étudiant ne vous appartient pas.');
        }
        return $etudiant;
    }

    #[Route('/', name: 'app_visite_index', methods: ['GET'])]
    public function index(Etudiant $etudiant): Response
    {
        $this->getEtudiantAndCheckAccess($etudiant);
        $visites = $etudiant->getVisites(); // Filtrage par l'étudiant

        return $this->render('visite/index.html.twig', [
            'etudiant' => $etudiant, 
            'visites' => $visites,
        ]);
    }

    #[Route('/new', name: 'app_visite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        $this->getEtudiantAndCheckAccess($etudiant);
        
        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ASSOCIATION : Lie la nouvelle visite à l'étudiant de la route
            $visite->setEtudiant($etudiant);
            
            $entityManager->persist($visite);
            $entityManager->flush();

            // REDIRECTION vers la liste des visites de CET étudiant
            return $this->redirectToRoute('app_visite_index', ['id_etudiant' => $etudiant->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visite/new.html.twig', [
            'etudiant' => $etudiant, 
            'visite' => $visite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visite_show', methods: ['GET'])]
    public function show(Etudiant $etudiant, Visite $visite): Response
    {
        $this->getEtudiantAndCheckAccess($etudiant); 
        
        // Vérifie que la visite est bien liée à l'étudiant de la route
        if ($visite->getEtudiant() !== $etudiant) {
            throw $this->createAccessDeniedException("Cette visite n'est pas liée à cet étudiant.");
        }

        return $this->render('visite/show.html.twig', [
            'etudiant' => $etudiant,
            'visite' => $visite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_visite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, Visite $visite, EntityManagerInterface $entityManager): Response
    {
        $this->getEtudiantAndCheckAccess($etudiant); 
        
        // Vérifie que la visite est bien liée à l'étudiant de la route
        if ($visite->getEtudiant() !== $etudiant) {
            throw $this->createAccessDeniedException("Cette visite n'est pas liée à cet étudiant.");
        }

        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_visite_show', [
                'id_etudiant' => $etudiant->getId(), 
                'id' => $visite->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visite/edit.html.twig', [
            'etudiant' => $etudiant,
            'visite' => $visite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visite_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant, Visite $visite, EntityManagerInterface $entityManager): Response
    {
        $this->getEtudiantAndCheckAccess($etudiant); 
        
        // Vérifie que la visite est bien liée à l'étudiant de la route
        if ($visite->getEtudiant() !== $etudiant) {
            throw $this->createAccessDeniedException("Cette visite n'est pas liée à cet étudiant.");
        }
        
        if ($this->isCsrfTokenValid('delete'.$visite->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($visite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_visite_index', ['id_etudiant' => $etudiant->getId()], Response::HTTP_SEE_OTHER);
    }
}

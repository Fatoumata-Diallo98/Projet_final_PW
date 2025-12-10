<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils; // 👈 AJOUT IMPORTANT

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')] // 👈 MODIFICATION DE LA ROUTE
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, le rediriger vers la page d'accueil ou tableau de bord
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('app_home');
        // }

        // Récupérer l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom d'utilisateur (email) entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')] // 👈 AJOUT DE LA ROUTE DE DÉCONNEXION
    public function logout(): void
    {
        // Cette méthode doit être vide, elle est interceptée par Symfony
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

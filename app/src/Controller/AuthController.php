<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données du formulaire
        $formData = $request->request->all();

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $formData['email']]);
        if ($existingUser) {
            $this->addFlash('error', 'Un compte avec cet email existe déjà.');
            return $this->redirectToRoute('app_login');
        }

        // Créer un nouvel utilisateur
        $user = new User();
        $user->setEmail($formData['email']);
        $user->setUsername($formData['username']);
        $user->setPlainPassword($formData['password']);

        // Enregistrer l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        // Ajouter un message flash
        $this->addFlash('success', 'Votre compte a été créé avec succès.');

        // Redirection vers la page d'accueil
        return $this->redirectToRoute('app_home');
    }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('auth/profile.html.twig');
    }

    #[Route('/banned', name: 'user_banned')]
    public function banned(): Response
    {
        return $this->render('auth/banned.html.twig');
    }

    #[Route('/access-denied', name: 'access_denied_page')]
    public function accessDenied(): Response
    {
        return $this->render('auth/accessdenied.html.twig');
    }
}

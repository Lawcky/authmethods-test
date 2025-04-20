<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/connect/github', name: 'connect_github')]
    public function redirectToGithub(): RedirectResponse
    {
        $params = http_build_query([
            'client_id' => $_ENV['GITHUB_CLIENT_ID'],
            'redirect_uri' => $_ENV['GITHUB_REDIRECT_URI'],
            'scope' => 'user:email'
        ]);
        return new RedirectResponse('https://github.com/login/oauth/authorize?' . $params);
    }
    
    // PAS DE #[Route] ici — c’est le YAML qui gère cette route maintenant
    public function githubCallback(): RedirectResponse
    {
        return $this->redirectToRoute('admin_dashboard'); // ou autre nom de route admin
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Ce code ne sera jamais exécuté !
        throw new \Exception('Ne jamais atteindre ce point : Symfony intercepte la route pour déconnecter l’utilisateur.');
    }

}
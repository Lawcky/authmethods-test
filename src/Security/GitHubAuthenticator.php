<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Client\Provider\Github;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GitHubAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private EntityManagerInterface $em,
        private RouterInterface $router
    ) {}

    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/connect/github/callback' && $request->query->has('code');
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        $provider = new Github([
            'clientId' => $_ENV['GITHUB_CLIENT_ID'],
            'clientSecret' => $_ENV['GITHUB_CLIENT_SECRET'],
            'redirectUri' => $_ENV['GITHUB_REDIRECT_URI']
        ]);

        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $request->query->get('code')
        ]);

        /** @var GithubResourceOwner $githubUser */
        $githubUser = $provider->getResourceOwner($accessToken);
        $githubId = $githubUser->getId();
        $email = $githubUser->getEmail() ?? 'github_' . $githubId . '@example.com';

        return new SelfValidatingPassport(
            new UserBadge($githubId, function() use ($githubId, $email, $githubUser) {
                $existingUser = $this->em->getRepository(User::class)->findOneBy(['githubId' => $githubId]);
        
                if ($existingUser) {
                    return $existingUser;
                }
        
                $user = new User();
                $user->setGithubId($githubId);
                $user->setEmail($email ?? 'placeholder@example.com');
                $user->setUsername('github_' . $githubId);
                $user->setRoles(['ROLE_USER']);
                $user->setFullName($githubUser->getName() ?? 'GitHub User');
                $user->setPassword(''); // GitHub login, no password needed
                $this->em->persist($user);
                $this->em->flush();
        
                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?RedirectResponse
    {
        return new RedirectResponse($this->router->generate('homepage'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?RedirectResponse
    {
        return new RedirectResponse($this->router->generate('security_login'));
    }
}

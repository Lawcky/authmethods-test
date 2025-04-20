<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class GitHubEntryPoint implements AuthenticationEntryPointInterface
{
    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        $params = http_build_query([
            'client_id' => $_ENV['GITHUB_CLIENT_ID'],
            'redirect_uri' => $_ENV['GITHUB_REDIRECT_URI'],
            'scope' => 'user:email'
        ]);

        return new RedirectResponse('https://github.com/login/oauth/authorize?' . $params);
    }
}
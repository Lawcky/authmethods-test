<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class AccessDeniedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RouterInterface $router,
    ) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof AccessDeniedException) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        if ($session->isStarted()) {
            $session->getFlashBag()->add('error', 'Accès refusé. Cette section est réservée aux administrateurs.');
        }

        $response = new RedirectResponse($this->router->generate('app_home')); // ou autre route publique
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}

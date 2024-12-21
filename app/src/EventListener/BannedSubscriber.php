<?php

namespace App\EventListener;

use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class BannedSubscriber
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();

        if (method_exists($user, 'getRoles') && $user->getRoles() === ['ROLE_BANNED']) {
            $response = new RedirectResponse($this->router->generate('user_banned'));
            $event->getRequest()->getSession()->save();
            $event->setResponse($response);
        }
    }
}
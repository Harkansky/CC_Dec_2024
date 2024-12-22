<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class BannedUserHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $content = "Vous n'avez pas accès à cette page";

        if ($request->attributes->get('user')->getRoles() === ['ROLE_BANNED']) {
            $content = "Vous avez été banni";
        }

        return new Response($content, 403);
    }
}
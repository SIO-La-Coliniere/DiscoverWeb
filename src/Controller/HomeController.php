<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(RequestStack $stack): Response
    {
        $session = $stack->getSession();
        $role = $session->get('role');

        if (!$role) {
            $this->addFlash('error', 'Vous devez vous connecter');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home/index.html.twig', [
            'role' => $role,
        ]);
    }
}

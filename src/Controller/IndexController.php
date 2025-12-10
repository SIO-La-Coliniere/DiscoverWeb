<?php

namespace App\Controller;
use App\Service\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(ApiClient $api, RequestStack $stack): Response
    {
        try {
            // TODO 1 : appeler l’API pour récupérer la liste des ministages
            $ministage = $api->get('/api/ministages', withAuth: true);
            // TODO 2 : extraire le tableau de ministages
        } catch (\Throwable $e) {
            $ministage = [];
            if ($stack->getSession()) {
                $this->addFlash('error', 'Impossible de récupérer les Ministages (API) : '.$e->getMessage());
            }
        }

        return $this->render('index/index.html.twig', [
            'ministages' => $ministage,
        ]);
    }
}

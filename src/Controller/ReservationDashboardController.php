<?php

namespace App\Controller;

use App\Service\ApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReservationDashboardController extends AbstractController
{
    #[Route('/reservation/dashboard', name: 'app_reservation_dashboard')]
    public function index(ApiClient $api, RequestStack $stack): Response
    {
        try {
            $data = $api->get('/api/reservations');
            $reservations = array_values($data) ?? [];
        } catch (\Throwable $e) {
            $reservations = [];
            echo 'error: ' . $e->getMessage();
            if ($stack->getSession()) {
                $this->addFlash('error', 'Impossible de récupérer les reservations (API) : '.$e->getMessage());
            }
        }

        return $this->render('reservation_dashboard/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }
    #[Route('/reservation/create', name: 'app_reservation_create')]
    public function create(ApiClient $api, RequestStack $stack): Response
    {
        try {
            $data = $api->get('/api/ministages');
            $reservations = array_values($data) ?? [];
        } catch (\Throwable $e) {
            $reservations = [];
            echo 'error: ' . $e->getMessage();
            if ($stack->getSession()) {
                $this->addFlash('error', 'Impossible de récupérer les reservations (API) : '.$e->getMessage());
            }
        }

        return $this->render('reservation_dashboard/create.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}

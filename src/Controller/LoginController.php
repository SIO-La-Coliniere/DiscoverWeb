<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ApiClient;
use Symfony\Component\HttpFoundation\Request;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function index(ApiClient $api, RequestStack $stack, Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('password', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('login', SubmitType::class, ['label' => 'Connexion'])
            ->getForm();

        $form->handleRequest($request);
        $session = $stack->getSession();
        $session->start();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $password = $data['password'];

            try {
                // 1️⃣ Login via API
                $loginResponse = $api->post('/api/login', [
                    'email' => $email,
                    'password' => $password,
                ], withAuth: false);

                if (!isset($loginResponse['token'])) {
                    $this->addFlash('error', 'Authentification échouée');
                    return $this->redirectToRoute('app_login');
                }

                // 2️⃣ Store token in session
                $session->set('api_token', $loginResponse['token']);

                // 3️⃣ Fetch user roles from API
                $roleResponse = $api->get('/api/user/' . $email, withAuth: false);
                $roles = $roleResponse['roles'] ?? [];

                if (empty($roles)) {
                    $this->addFlash('error', 'Aucun rôle trouvé pour cet utilisateur');
                    return $this->redirectToRoute('app_login');
                }

                // Store the first role in session (adjust if multiple roles)
                $session->set('role', $roles[0]);

                // 4️⃣ Redirect to home
                return $this->redirectToRoute('app_home');

            } catch (\Throwable $e) {
                $this->addFlash('error', 'Login incorrect : ' . $e->getMessage());
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN'); // Sécurité admin

        // Plus tard, on chargera les données depuis la base
        $fakeUsers = [
            ['email' => 'admin@kl.com', 'role' => 'ADMIN', 'verified' => true],
            ['email' => 'user1@kl.com', 'role' => 'USER', 'verified' => true],
            ['email' => 'user2@kl.com', 'role' => 'USER', 'verified' => false],
        ];

        $fakeCourses = [
            ['title' => 'Cursus guitare', 'theme' => 'Musique', 'price' => 50],
            ['title' => 'Cursus développement web', 'theme' => 'Informatique', 'price' => 60],
        ];

        $fakePurchases = [
            ['user' => 'user1@kl.com', 'course' => 'Cursus guitare', 'date' => '2025-07-10'],
            ['user' => 'user2@kl.com', 'course' => 'Cursus développement web', 'date' => '2025-07-12'],
        ];

        return $this->render('pages/admin.html.twig', [
            'users' => $fakeUsers,
            'courses' => $fakeCourses,
            'purchases' => $fakePurchases
        ]);
    }
}

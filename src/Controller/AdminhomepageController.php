<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
final class AdminhomepageController extends AbstractController
{
    #[Route('/adminhomepage', name: 'adminhomepage')]
    public function index(): Response
    {
        return $this->render('adminhomepage/index.html.twig', [
            'controller_name' => 'AdminhomepageController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WelcomepageController extends AbstractController
{
    #[Route('/', name: 'welcomepage')]
    public function index(): Response
    {
        return $this->render('welcomepage/welcome.html.twig', [
            'controller_name' => 'WelcomepageController',
        ]);
    }
}

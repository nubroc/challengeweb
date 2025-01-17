<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
final class UserhomepageController extends AbstractController
{
    #[Route('/userhomepage', name: 'userhomepage')]
    public function index(): Response
    {
        return $this->render('userhomepage/index.html.twig', [
            'controller_name' => 'UserhomepageController',
        ]);
    }
}

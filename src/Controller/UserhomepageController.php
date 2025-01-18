<?php

namespace App\Controller;

use App\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

#[IsGranted('ROLE_USER')]
final class UserhomepageController extends AbstractController
{
    #[Route('/userhomepage', name: 'userhomepage')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $accounts = $em->getRepository(Account::class)->findBy(['user' => $user]);

        return $this->render('userhomepage/index.html.twig', [
            'controller_name' => 'UserhomepageController',
            'accounts' => $accounts,
        ]);
    }
}

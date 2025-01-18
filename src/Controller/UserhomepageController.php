<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

#[IsGranted('ROLE_USER')]
final class UserhomepageController extends AbstractController
{
    #[Route('/userhomepage', name: 'userhomepage')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $accounts = $em->getRepository(Account::class)->findBy(['user' => $user]);

        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $account->setUser($user);
            $account->setAccountNumber(uniqid('ACC-'));

            if ($account->getType() === 'epargne' && $account->getBalance() < 10) {
                $this->addFlash('error', 'Un compte épargne doit avoir un solde initial d\'au moins 10€.');
            } else {
                $em->persist($account);
                $em->flush();
                $this->addFlash('success', 'Compte créé avec succès !');
                return $this->redirectToRoute('userhomepage');
            }
        }

        return $this->render('userhomepage/index.html.twig', [
            'controller_name' => 'UserhomepageController',
            'accounts' => $accounts,
            'form' => $form->createView(),
        ]);
    }
}
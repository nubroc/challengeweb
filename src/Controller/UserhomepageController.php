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

    #[Route('/account/withdraw/{id}', name: 'account_withdraw')]
    public function withdraw(Request $request, Account $account, EntityManagerInterface $em): Response
    {
        $amount = $request->request->get('amount');
        if ($amount > 0 && $account->getBalance() >= $amount) {
            $account->setBalance($account->getBalance() - $amount);
            $em->flush();
            $this->addFlash('success', 'Retrait effectué avec succès.');
        } else {
            $this->addFlash('error', 'Montant invalide ou solde insuffisant.');
        }

        return $this->redirectToRoute('userhomepage');
    }

    #[Route('/account/transfer', name: 'account_transfer')]
    public function transfer(Request $request, EntityManagerInterface $em): Response
    {
        $fromAccountId = $request->request->get('from_account_id');
        $toAccountId = $request->request->get('to_account_id');
        $amount = $request->request->get('amount');

        $fromAccount = $em->getRepository(Account::class)->find($fromAccountId);
        $toAccount = $em->getRepository(Account::class)->find($toAccountId);

        if ($fromAccount && $toAccount && $amount > 0 && $fromAccount->getBalance() >= $amount) {
            $fromAccount->setBalance($fromAccount->getBalance() - $amount);
            $toAccount->setBalance($toAccount->getBalance() + $amount);
            $em->flush();
            $this->addFlash('success', 'Virement effectué avec succès.');
        } else {
            $this->addFlash('error', 'Montant invalide, solde insuffisant ou comptes non trouvés.');
        }

        return $this->redirectToRoute('userhomepage');
    }
}
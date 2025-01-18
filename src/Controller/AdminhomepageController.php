<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Transaction;
use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
final class AdminhomepageController extends AbstractController
{
    #[Route('/adminhomepage', name: 'adminhomepage')]
    public function index(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();
        $transactions = $em->getRepository(Transaction::class)->findAll();
        $accounts = $em->getRepository(Account::class)->findAll();

        return $this->render('adminhomepage/index.html.twig', [
            'controller_name' => 'AdminhomepageController',
            'users' => $users,
            'transactions' => $transactions,
            'accounts' => $accounts,
        ]);
    }

    #[Route('/adminhomepage/block_account/{id}', name: 'block_account')]
    public function blockAccount(int $id, EntityManagerInterface $em): Response
    {
        $account = $em->getRepository(Account::class)->find($id);
        if ($account) {
            $this->addFlash('success', 'Account blocked successfully.');
        } else {
            $this->addFlash('error', 'Account not found.');
        }
        return $this->redirectToRoute('adminhomepage');
    }

    #[Route('/adminhomepage/unblock_account/{id}', name: 'unblock_account')]
    public function unblockAccount(int $id, EntityManagerInterface $em): Response
    {
        $account = $em->getRepository(Account::class)->find($id);
        if ($account) {
            $this->addFlash('success', 'Account unblocked successfully.');
        } else {
            $this->addFlash('error', 'Account not found.');
        }
        return $this->redirectToRoute('adminhomepage');
    }

    #[Route('/adminhomepage/cancel_transaction/{id}', name: 'cancel_transaction')]
    public function cancelTransaction(int $id, EntityManagerInterface $em): Response
    {
        $transaction = $em->getRepository(Transaction::class)->find($id);
        if ($transaction) {
            $this->addFlash('success', 'Transaction cancelled successfully.');
        } else {
            $this->addFlash('error', 'Transaction not found.');
        }
        return $this->redirectToRoute('adminhomepage');
    }
}

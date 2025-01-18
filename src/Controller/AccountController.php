<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/create', name: 'account_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $account->setUser($user);

            $account->setAccountNumber(uniqid('ACC-'));

            // Règles de gestion
            if ($account->getType() === 'epargne' && $account->getBalance() < 10) {
                $this->addFlash('error', 'Un compte épargne doit avoir un solde initial d\'au moins 10€.');
                return $this->redirectToRoute('account_create');
            }

            $em->persist($account);
            $em->flush();

            $this->addFlash('success', 'Compte créé avec succès !');
            return $this->redirectToRoute('user_homepage');
        }

        return $this->render('userhomepage/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account/{id}', name: 'account_view')]
    public function view(int $id, EntityManagerInterface $em): Response
    {
        $account = $em->getRepository(Account::class)->find($id);

        if (!$account || $account->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('Compte non trouvé.');
        }

        return $this->render('account/view.html.twig', [
            'account' => $account,
        ]);
    }

    #[Route('/account/{id}/close', name: 'account_close')]
    public function close(int $id, EntityManagerInterface $em): Response
    {
        $account = $em->getRepository(Account::class)->find($id);

        if (!$account || $account->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('Compte non trouvé.');
        }

        $em->remove($account);
        $em->flush();

        $this->addFlash('success', 'Compte clôturé avec succès.');
        return $this->redirectToRoute('userhomepage');
    }

    #[Route('/account/new', name: 'account_new')]
    public function new(Request $request, ValidatorInterface $validator): Response
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($account->getType() === 'épargne' && $account->getBalance() < 10) {
                $this->addFlash('error', 'Le solde initial pour un compte épargne doit être d\'au moins 10€.');
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($account);
                $entityManager->flush();

                return $this->redirectToRoute('account_success');
            }
        }

        return $this->render('account/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

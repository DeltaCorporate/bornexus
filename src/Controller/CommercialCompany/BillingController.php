<?php

namespace App\Controller\CommercialCompany;

use App\Entity\Billing;
use App\Entity\User;
use App\Form\BillingType;
use App\Pdf\BillingPdf;
use App\Repository\BillingsRepository;
use App\Service\BillingStripeService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/billing')]
class BillingController extends AbstractController
{

    public  function __construct(
        private Security $security,
    ){}
    #[Route('/', name: 'app_billing_index', methods: ['GET'])]
    public function index(Request $request, BillingsRepository $billingsRepository, PaginatorInterface $paginator): Response
    {
        $type = $request->query->get('type') ?? 'quote';
        return $this->render('billing/index.html.twig', [
                'typeSelected' => $type,
                'typeList' => Billing::TYPE
            ]);
    }

    #[Route('/new', name: 'app_billing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserService $userService): Response
    {
        $company = $this->security->getUser()->getCompany();
        $users = $entityManager->getRepository(User::class)->findByCompanyAndRole($company,'ROLE_USER');
        $billing = new Billing();
        $billing->setCompany($company);
        $billing->setEmitedAt(new \DateTimeImmutable());
        $billing->setType('quote');
        $form = $this->createForm(BillingType::class, $billing,compact('users'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $billing->setStatus('');
            $entityManager->persist($billing);
            $entityManager->flush();
            return $this->redirectToRoute('commercial_company_app_billing_edit', ['id' => $billing->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('billing/new.html.twig', [
            'billing' => $billing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_billing_show', methods: ['GET'])]
    public function show(Billing $billing): Response
    {
        return $this->render('billing/show.html.twig', [
            'billing' => $billing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_billing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Billing $billing, EntityManagerInterface $entityManager,BillingsRepository $billingsRepository): Response
    {
        $company = $this->security->getUser()->getCompany();

        $users = $entityManager->getRepository(User::class)->findByCompanyAndRole($company,'ROLE_USER');

        $form = $this->createForm(BillingType::class, $billing,compact('users'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           if($billing->getPaymentMethod() == 'stripe' && $billing->getType() != 'quote'){
               $stripe = new BillingStripeService($billing);
               $session = $stripe->create(
                   $this->generateUrl('app_payment_stripe_result',['type' => 'success'],UrlGeneratorInterface::ABSOLUTE_URL),
                   $this->generateUrl('app_payment_stripe_result',['type' => 'error'],UrlGeneratorInterface::ABSOLUTE_URL)
               );
               $entityManager->flush();
           }
           if($billing->getPaymentMethod() != 'stripe' && $billing->getType() != 'quote')
               $billingsRepository->updatePriceStatus($billing);

            return $this->redirectToRoute('commercial_company_app_billing_index', [
                'type' => $billing->getType()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('billing/edit.html.twig', [
            'billing' => $billing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/pdf', name: 'app_billing_pdf', )]
    public function showPdf(Request $request, Billing $billing, EntityManagerInterface $entityManager)
    {

        $pdf = new BillingPdf($billing);
        return $pdf->generate();

    }


    #[Route('/{id}/delete', name: 'app_billing_delete', methods: ['DELETE'])]
    public function delete(Request $request, Billing $billing, EntityManagerInterface $entityManager): Response
    {

        $type = $billing->getType();
        if ($this->isCsrfTokenValid('delete'.$billing->getId(), $request->request->get('_token'))) {
            $entityManager->remove($billing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commercial_company_app_billing_index', [
            'type' => $type
        ], Response::HTTP_SEE_OTHER);
    }
}

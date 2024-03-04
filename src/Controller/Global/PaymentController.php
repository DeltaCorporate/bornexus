<?php

namespace App\Controller\Global;

use App\Entity\Billing;
use App\Repository\BillingsRepository;
use App\Service\BillingStripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/stripe/webhook', name: 'app_payment_stripe',methods: ['GET'])]
    public function stripeWebHook(): Response {

        return new Response();
    }

    #[Route('/stripe/checkout_redirect/{billing_token}', name: 'app_payment_stripe_checkout', methods: ['GET'])]
    public function billingRedirectCheckoutUrl(string $billing_token, BillingsRepository $billingsRepository): Response {
        $billing = $billingsRepository->getBillingFromToken($billing_token);
        if(!$billing)
            return $this->redirectToRoute('app_index');
        $billing = new BillingStripeService($billing);
        $session = $billing->retrieve();
        $url = $session->url ?? null;
        if(!$url)
            return $this->redirectToRoute('app_index');

        return $this->redirect($url);
    }

    #[Route('/result/{type}', name: 'app_payment_stripe_result', methods: ['GET'])]
    public function paymentResult(string $type): Response {

        return $this->render('payment/payment_result.html.twig',[
            'type' => $type
        ]);
    }


}

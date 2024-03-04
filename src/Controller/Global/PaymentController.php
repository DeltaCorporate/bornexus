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
    #[Route('/stripe/webhook', name: 'app_payment_stripe',methods: ['POST'])]
    public function stripeWebHook(BillingsRepository $billingsRepository,EntityManagerInterface $entityManager): JsonResponse {
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        if($event->type === 'checkout.session.completed'){
            $session = $event->data->object;
            $billing = $billingsRepository->find($session->metadata->billing_id);
            if($session->payment_status === 'paid'){
                $billing->setAmountPaid($session->amount_total/100);
                $billing->setStatus('paid');
            }else{
                $billing->setAmountPaid(0);
                $billing->setStatus('unpaid');
            }
            $entityManager->flush();
        }

        return new JsonResponse([]);
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

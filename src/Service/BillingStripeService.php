<?php

namespace App\Service;

use App\Entity\Billing;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Service\Checkout\SessionService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class BillingStripeService extends StripeService
{
    private array $items = [];

    private Billing $billing;


    public function __construct(Billing $billing)
    {
        parent::__construct();
        $this->billing = $billing;
        $this->billing->calculTotalPrices();

    }

    private function router(#[Autowire] RouterInterface $router)
    {
        return $router;
    }

    public function create(string $successUrl = '',string $errorUrl = ''): \Stripe\Checkout\Session{

        $billingCompanyCatalogs = $this->billing->getBillingsCompanyCatalogs();
        foreach($billingCompanyCatalogs as $billingCompanyCatalog){
            $this->addItem([
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $billingCompanyCatalog->getCompanyCatalog()->getProduct()->getName(),
                    ],
                    'unit_amount' =>  Billing::round($billingCompanyCatalog->getPriceTtcUnit() - ( $billingCompanyCatalog->getPriceTtcUnit() * $this->billing->getDiscount()/100))*100
                ],
                'quantity' => $billingCompanyCatalog->getQuantity()
            ]);
        }
        $session = $this->createCheckoutSession(
            $this->items,
            $successUrl,
            $errorUrl
        );
        $this->billing->setCheckoutSession($session->id);

        return $session;
    }

    public function getBilling()
    {
        return $this->billing;
    }

    public function retrieve(){
        if(!$this->billing->getCheckoutSession())
            return null;
        $checkoutSessionId = $this->billing->getCheckoutSession();
        return $this->retrieveCheckoutSession($checkoutSessionId);
    }

    public function addItem(array $item)
    {
        $this->items[] = $item;
    }


}
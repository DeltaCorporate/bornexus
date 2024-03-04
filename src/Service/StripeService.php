<?php
namespace App\Service;

use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService
{
    private StripeClient $stripeClient;

    const CS_URL = "https://checkout.stripe.com/c/pay/";
    public function __construct()
    {
        $this->stripeClient = new StripeClient($_ENV['STRIPE_SECRET_KEY']);
    }

    public function createCheckoutSession(array $lineItems,string $successUrl = '',string $errorUrl = '',array $metadata = []): CheckoutSession
    {
        return $this->stripeClient->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $errorUrl,
            'metadata' => $metadata
        ]);
    }

    public function retrieveCheckoutSession(string $checkoutSessionId): CheckoutSession
    {
        return $this->stripeClient->checkout->sessions->retrieve($checkoutSessionId);
    }

    public function buildCheckoutUrl($checkoutSessionId): string
    {
        return self::CS_URL . $checkoutSessionId;
    }

}

<?php
namespace App\Twig\Components\Billing;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'billing/components/billing_card.html.twig')]
class BillingCard
{
    
    public function __construct(
        public string $title = '',
        public string $description = '',
        public array $routeAction = []
    ) {
    }

   
}
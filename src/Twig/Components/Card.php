<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/card.html.twig')]
class Card
{
    
    public function __construct(public string $className = '') {

    }

   
}
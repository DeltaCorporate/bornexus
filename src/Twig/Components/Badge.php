<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/badge.html.twig')]
class Badge
{
    
    public function __construct(
        public string $text = '',
        public string $color = 'primary',
        public string $textColor = 'text-dark',
        public string $size = 'base',
        public string $fontSize = 'md',
        public string $weight = 'font-medium',
        public string $radius = 'rounded-full',
        public string $balise = 'button',
        /**
         * @var 'solid' | 'outline'
         */
        public string $variant = 'solid',
        public array $attributes = []
 
    ) {
    }

   
}
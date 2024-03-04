<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/dropdown.html.twig')]
class Dropdown
{
    
    public function __construct(
        public string $text = '',
        public string $color = 'transparent',
        public string $size = 'base',
        public string $textColor = 'text-dark',
        public string $fontSize = 'md',
        public string $weight = 'font-medium',
        public string $radius = 'rounded-md',
        /**
         * @var 'solid' | 'outline'
         */
        public array $attributes = []
 
    ) {
    }

   
}
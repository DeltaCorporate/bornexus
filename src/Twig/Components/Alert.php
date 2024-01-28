<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/alert.html.twig')]
class Alert
{
    
    public function __construct(
        public string $text = '',
        public string $icon = '',
        public string $color = 'primary',
        public string $size = 'base',
        public string $textColor = 'text-text',
        public string $borderWidth = '0',
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
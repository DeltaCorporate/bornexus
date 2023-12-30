<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/button.html.twig')]
class Button
{
    
    public function __construct(
        public string $text = '',
        public string $icon = '',
        public string $color = 'primary',
        public string $textColor = 'text-text',
        public string $size = 'base',
        public string $borderWidth = '2',
        public string $fontSize = 'md',
        public string $weight = 'font-medium',
        public string $type = 'button',
        public string $href = '#',
        public string $radius = 'rounded-md',
        public string $balise = 'button',
        /**
         * @var 'solid' | 'outline'
         */
        public string $variant = 'solid',
        public array $attributes = []
 
    ) {
    }

   
}
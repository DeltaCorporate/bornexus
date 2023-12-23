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
        public string $size = 'md',
        public string $weight = 'medium',
        public string $balise = 'button',
        public array $attributes = []
 
    ) {
  
    }

   
}
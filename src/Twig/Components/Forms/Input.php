<?php
namespace App\Twig\Components\Forms;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/forms/input.html.twig')]
class Input
{
        
    public function __construct(
    
        public string $type = 'text',
        public string $color = 'base',
        public string $size = 'base',
        public string $textColor = 'text-accent',
        public string $id = '',
        public string $placeholder='',
        public string $borderWidth = '0',
        public string $icon = '0',
        public string $fontSize = 'md',
        public string $weight = 'font-medium',
        public string $value = '',
        public string $radius = 'rounded-md',
        public array $attributes = [],
        public array $iconAttributes = []
 
    ) {
    }

   
}
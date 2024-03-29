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
        public string $textColor = 'text-dark',
        public string $size = 'base',
        public string $borderWidth = '2',
        public string $fontSize = 'md',
        public string $weight = 'font-medium',
        public string $radius = 'rounded-md',
        public string $balise = 'button',
        public string $class = '',
        public string $iconPosition = 'left',
        /**
         * @var 'solid' | 'outline'
         */
        public string $variant = 'solid',

    ) {
    }

   
}
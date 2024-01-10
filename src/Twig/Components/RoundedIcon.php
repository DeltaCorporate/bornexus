<?php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/roundedIcon.html.twig')]
class RoundedIcon
{
    
    public function __construct(
       public string $icon = '',
       public string $bgColor = 'base',
       public string $color = 'neutral',
       public string $size = '12',
       public string $fontSize = '2xl',
       public string $route = 'app_general_info_designkit'
    ) {
        
    }

   
}
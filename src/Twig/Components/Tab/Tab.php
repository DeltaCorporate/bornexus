<?php
namespace App\Twig\Components\Tab;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/tab/tab.html.twig')]
class Tab
{
    
    public function __construct(
        public bool $active = false,
        public string $size = "base",
        public string $text = ""
    ) {
    }

   
}
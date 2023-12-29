<?php
// src/Twig/Components/Sidebar.php
namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\HttpKernel\KernelInterface;

use Twig\Environment;

#[AsTwigComponent(template: 'components/Sidebar/sidebar.html.twig')]
class Sidebar
{
    
    public string $textColor;
    public string $textColorDropdown;
    public string $backgroundColor;
    public string $hoverColor;
    public string $companyName;
    public string $title;
    public float $logoSizeRem;

    public string $logo;
    private $menuItems;
    private $twig;
    
    public function __construct(KernelInterface $kernel, Environment $twig){
        $projectDir = $kernel->getProjectDir();
        $this->twig = $twig;
        $this->menuItems = json_decode(file_get_contents($projectDir.'/config/menu.json'));
    }
    public function generateMenuItems(array $menuItems = null,bool $isDropdown = false){
            
            $menuItems = $menuItems ?? $this->menuItems;
        
            foreach($menuItems as $menuItem){
                $menuItem = (array)$menuItem;
            
            if(isset($menuItem['subMenu'])){
                $menuItem['sidebar'] = $this;
                echo $this->twig->render('components/Sidebar/menuDropdown.html.twig',$menuItem); 
            }
            else{
                $menuItem['textColor'] = !$isDropdown ? $this->textColor : $this->textColorDropdown;
                $menuItem['hoverColor'] = $this->hoverColor;
                
                echo $this->twig->render('components/Sidebar/menuItem.html.twig',$menuItem); 
            }
        }
    }

    
}

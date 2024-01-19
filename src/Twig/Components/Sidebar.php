<?php
// src/Twig/Components/Sidebar.php
namespace App\Twig\Components;

use App\Enum\RoleEnum;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
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
    private array $menuItems;

    public function __construct(KernelInterface $kernel,private readonly Environment $twig,private readonly AuthorizationCheckerInterface $authorizationChecker){
        $projectDir = $kernel->getProjectDir();
        $this->menuItems = require $projectDir.'/config/menu.php';
//        dd($this->menuItems);
    }
    public function generateMenuItems(array $menuItems = null,bool $isDropdown = false): void
    {
            
        $menuItems = $menuItems ?? $this->menuItems;
        foreach($menuItems as $menuItem){
            $menuItem = (array)$menuItem;

            $role = $menuItem['role'] ?? RoleEnum::ROLE_USER;
            if($this->authorizationChecker->isGranted($role->name)){
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

    
}

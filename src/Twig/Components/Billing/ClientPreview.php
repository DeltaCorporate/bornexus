<?php

namespace App\Twig\Components\Billing;

use App\Entity\User;
use App\Form\ClientReadOnlyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\Form\FormInterface;

#[AsLiveComponent(template: 'billing/components/client_preview.html.twig')]
class ClientPreview extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?User $user = null;

    public function __construct(
        private EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ClientReadOnlyType::class, $this->user);
    }
    #[LiveListener('billingForm:changeUser')]
   public function changeUserForm(#[LiveArg] User $user){
        $this->user = $user;
    }
    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }



}
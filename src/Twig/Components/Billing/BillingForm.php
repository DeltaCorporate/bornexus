<?php

namespace App\Twig\Components\Billing;

use App\Entity\Billing;
use App\Entity\User;
use App\Form\BillingType;
use App\Form\ClientReadOnlyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\LiveResponder;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsLiveComponent(template: 'billing/_form.html.twig')]
class BillingForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp(fieldName: 'billingForm:billing')]
    public ?Billing $billing = null;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LiveResponder $responder
       ){
        $this->entityManager = $entityManager;
        $this->responder = $this->responder;
    }

    protected function instantiateForm(): FormInterface
    {
        $this->changeUserForm();
        $users = $this->entityManager->getRepository(User::class)->findByCompanyAndRole($this->billing->getCompany(),'ROLE_USER');

        return $this->createForm(BillingType::class, $this->billing,[
            'users' => $users
        ]);
    }
    #[PostMount]
    public function postMount(){
        $this->billing->calculTotalPrices();
        $this->changeUserForm();
    }

    #[LiveListener('line_item:doRefresh')]
    public function refreshBilling(): void
    {
       $entityManager = $this->entityManager;
       $billing = $this->billing;
       $entityManager->refresh($billing);
       $billing->calculTotalPrices();
    }
    #[LiveAction]
    public function changeUserForm(){
        $this->userForm = $this->createForm(ClientReadOnlyType::class, $this->billing->getUsers())->createView();

        $this->responder->emit('billingForm:changeUser',[
            'user' => $this->billing->getUsers()
        ]);
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }



}
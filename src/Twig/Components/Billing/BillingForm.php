<?php

namespace App\Twig\Components\Billing;

use App\Entity\Billing;
use App\Entity\User;
use App\Form\BillingType;
use App\Form\ClientReadOnlyType;
use App\Repository\BillingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
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

    public $key = 0;

    #[LiveProp(fieldName: 'billingForm:billing',hydrateWith: 'hydrate', dehydrateWith: 'dehydrate')]
    public ?Billing $billing = null;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LiveResponder $responder
       ){

        $this->entityManager = $entityManager;
        $this->responder = $responder;
    }

    public function hydrate($value)
    {
        return unserialize($value);
    }

    public function dehydrate($value)
    {
        return serialize($value);
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
        $this->billing = $this->entityManager->getRepository(Billing::class)->find($this->billing->getId());
        $this->billing->calculTotalPrices();
    }
    #[LiveAction]
    public function changeUserForm(){
        $this->userForm = $this->createForm(ClientReadOnlyType::class, $this->billing->getUsers())->createView();

        $this->responder->emit('billingForm:changeUser',[
            'user' => $this->billing->getUsers()
        ]);
    }

    #[LiveAction]
    public function createInvoiceFromQuote()
    {
        $billingRepository = $this->entityManager->getRepository(Billing::class);
        $billing = $billingRepository->find($this->billing->getId());
        $newBilling = $billingRepository->cloneBilling($billing,'invoice');

        return $this->redirectToRoute('commercial_company_app_billing_edit',['id' => $newBilling->getId()]);
    }

    #[LiveAction]
    public function delete()
    {
        $entityManager = $this->entityManager;
        $billingRepository = $entityManager->getRepository(Billing::class);
        $billing = $billingRepository->find($this->billing->getId());
        $billingRepository->delete($billing);
        $entityManager->flush();

        return $this->redirectToRoute('commercial_company_app_billing_index');
    }

    private function getDataModelValue(): ?string
    {
        return 'norender|*';
    }

}
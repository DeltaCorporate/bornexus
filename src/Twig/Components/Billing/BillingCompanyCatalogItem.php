<?php
namespace App\Twig\Components\Billing;

use App\Entity\Company;
use App\Entity\CompanyCatalog;
use App\Form\BillingCompanyCatalogType;
use App\Repository\CompanyCatalogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Entity\BillingCompanyCatalog;
use Symfony\UX\TwigComponent\Attribute\PostMount;

#[AsLiveComponent(template: 'billing/components/billing_company_catalog_item.html.twig')]
class BillingCompanyCatalogItem
{

    use DefaultActionTrait;

    #[LiveProp(writable: ['quantity','discount'])]
    public ?BillingCompanyCatalog $billingCompanyCatalog;

    #[LiveProp(writable: true)]
    public int $company_catalog = -1;

    public ?Form $form = null;
    public ?FormView $formView = null;
    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        FormFactoryInterface $formFactory
    ){
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
    }


    public function mount(BillingCompanyCatalog $billingCompanyCatalog){
        $this->billingCompanyCatalog = $billingCompanyCatalog;
        $this->company_catalog = $billingCompanyCatalog->getCompanyCatalog()->getId();
        $this->createForm();
    }

    #[LiveAction]
    public function save(): void{
        $this->createForm();
        if($this->billingCompanyCatalog->getId()){
            $this->billingCompanyCatalog->setCompanyCatalog(
                $this->entityManager->getRepository(CompanyCatalog::class)->find($this->company_catalog)
            );
            $this->entityManager->persist($this->billingCompanyCatalog);
            $this->entityManager->flush();
        }

    }

    #[LiveAction]
    public function delete()
    {
        $this->entityManager->remove($this->billingCompanyCatalog);
        $this->entityManager->flush();
    }



    public function createForm(): Form
    {
        $this->form = $this->formFactory->create(BillingCompanyCatalogType::class, $this->billingCompanyCatalog,[
           'company_catalogs' => $this->billingCompanyCatalog->getCompanyCatalog()->getCompany()->getCompanyCatalogs()
       ]);

        $this->formView = $this->form->createView();
        return $this->form;
    }







}

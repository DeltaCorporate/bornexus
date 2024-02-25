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
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Entity\BillingCompanyCatalog;
use Symfony\UX\LiveComponent\LiveResponder;
use Symfony\UX\TwigComponent\Attribute\PostMount;

#[AsLiveComponent(template: 'billing/components/billing_company_catalog_item.html.twig')]
class BillingCompanyCatalogItem
{

    use DefaultActionTrait;
    use ComponentToolsTrait;


    #[LiveProp]
    public int $key;

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

    public function hydrate($value){
        return unserialize($value);
    }

    public function dehydrate($value){
        return serialize($value);
    }

    public function mount(BillingCompanyCatalog $billingCompanyCatalog){
        $this->billingCompanyCatalog = $billingCompanyCatalog;
        if($this->billingCompanyCatalog->hasCompanyCatalog())
            $this->company_catalog = $billingCompanyCatalog->getCompanyCatalog()->getId();
        $this->createForm();
    }

    #[LiveAction]
    public function save(LiveResponder $responder): void{
        $this->createForm();
        if($this->billingCompanyCatalog->getId()){

            $this->billingCompanyCatalog->setCompanyCatalog(
                    $this->entityManager->getRepository(CompanyCatalog::class)->find($this->company_catalog)
            );

            $this->entityManager->persist($this->billingCompanyCatalog);
            $this->entityManager->flush();
        }
        $responder->emitUp('line_item:save',[
            'billingCompanyCatalog' => $this->dehydrate($this->billingCompanyCatalog),
        ]);



    }

    #[LiveAction]
    public function delete(LiveResponder $responder)
    {
        $this->entityManager->remove($this->billingCompanyCatalog);
        $this->entityManager->flush();
        $responder->emitUp('line_item:delete',[
            'key' => $this->key
        ]);

    }



    public function createForm(): Form
    {

        $this->form = $this->formFactory->create(BillingCompanyCatalogType::class, $this->billingCompanyCatalog,[
           'company_catalogs' => $this->billingCompanyCatalog
                                      ->getBilling()
                                      ->getCompany()
                                      ->getCompanyCatalogs()
       ]);

        $this->formView = $this->form->createView();
        return $this->form;
    }







}

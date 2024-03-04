<?php

namespace App\Form;

use App\Entity\Billing;
use App\Entity\BillingCompanyCatalog;
use Doctrine\ORM\Query\Expr\Select;
use http\Client\Curl\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingCompanyCatalogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $billingCompanyCatalog = $options['data']; // L'objet BillingCompanyCatalog
        $builder
            ->add('company_catalog',ChoiceType::class,[
                'choices' => $options['company_catalogs'],
                'choice_label' => function($companyCatalog){
                    $product = $companyCatalog->getProduct();
                    return $product->getName() . '(' . $companyCatalog->getProductPriceWithMargin() . '€)';
                },

                'choice_value' => function($companyCatalog = null){
                      return $companyCatalog ? $companyCatalog->getId() : null;
                },
                'attr' => [
                    'data-action' => 'change->live#action'
                ]
            ])
            ->add('quantity',IntegerType::class,[
                'attr' =>
                    [
                        'min' => 1
                    ]
            ])
            ->add('priceHt',TextType::class,[
                'mapped' => false,
                'data' => $billingCompanyCatalog->getPriceHt(),
                'attr' => [
                    'disabled' => true,
                ]
            ])
            ->add('discount',IntegerType::class,[
                'attr' =>
                    [
                        'min' => 0,
                        'max' => 100
                    ]
            ])
            ->add('priceTtc',TextType::class,[
                'mapped' => false,
                'data' => $billingCompanyCatalog->getPriceTtc(),
                'attr' => [
                    'disabled' => true,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

        $resolver->setDefaults([
            'data_class' => BillingCompanyCatalog::class,
            'company_catalogs' => [],

        ]);
    }
}

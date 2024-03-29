<?php

namespace App\Form;

use App\Entity\Billing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('emited_at',DateType::class,[
                'label' => "Date d'émission"
            ])
            ->add('payment_method',ChoiceType::class,[
                'label' => 'Moyen de paiement',
                'choices' => array_flip(Billing::PAYMENT_METHOD)
            ])
            ->add('discount',NumberType::class,[
                'label' => 'Réduction',
                'html5' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 100
                ],
                'required' => false
            ])
            ->add('users',ChoiceType::class,[
                'label' => 'Client',
                'choices' => $options['users'],
                'choice_label' => 'fullName',
                'attr' => [
                    'data-action' => 'change->live#action',
                    'data-live-action-param' => 'changeUserForm'
                ]
            ])
        ;

        if($options['data']->getType() === 'invoice' && $options['data']->getPaymentMethod() != 'stripe'){
            $builder->add('amount_paid',NumberType::class,[
                'label' => 'Montant payé en €',
                'html5' => true,
                'attr' => [
                    'min' => 0,
                ],
                'required' => false
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Billing::class,
            'users' => []
        ]);
    }
}

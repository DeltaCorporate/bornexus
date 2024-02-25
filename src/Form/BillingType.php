<?php

namespace App\Form;

use App\Entity\Billing;
use Doctrine\ORM\Query\Expr\Select;
use http\Client\Curl\User;
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
            ->add('type', ChoiceType::class,[
                'choices' => array_flip(Billing::TYPE),
                'expanded' => true
            ])
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
                    'min' => 0
                ],
                'required' => false
            ])
            ->add('users',ChoiceType::class,[
                'label' => 'Client',
                'choices' => $options['users'],
                'choice_label' => 'fullName',
                'choice_value' => 'id',
                'attr' => [
                    'data-action' => 'change->live#action',
                    'data-action-name' => 'changeUserForm'
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Billing::class,
            'users' => []
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientReadOnlyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextType::class,[
                'attr' => [
                    'readonly' => true
                ],
                'label' => 'Email'
            ])
            ->add('firstname',TextType::class,[
                'attr' => [
                    'readonly' => true
                ],
                'label' => 'Prénom'
            ])
            ->add('lastname',TextType::class,[
                'attr' => [
                    'readonly' => true
                ],
                'label' => 'Nom'
            ])
            ->add('address',TextType::class,[
                'attr' => [
                    'readonly' => true
                ],
                'label' => 'Adresse'
            ])
            ->add('country',TextType::class,[
                'attr' => [
                    'readonly' => true
                ],
                'label' => 'Pays'
            ])
            ->add('zip',TextType::class,[
                    'attr' => [
                        'readonly' => true
                    ],
                    'label' => 'Code postal'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

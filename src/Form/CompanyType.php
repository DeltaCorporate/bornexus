<?php

namespace App\Form;

use App\Entity\Company;
use Faker\Provider\ar_EG\Text;
use phpDocumentor\Reflection\PseudoTypes\IntegerRange;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, )
            ->add('siret')
            ->add('zip')
            ->add('address')
            ->add('country')
            ->add('website')
            ->add('iban')
            ->add('tva', ChoiceType::class, [
                'label' => 'Taux de TVA',
                'attr' =>[
                    'placeholder' => 'Choisissez un taux de TVA',
                ],
                'choices'=>array_flip(Company::TVA)
            ])
            ->add('tva_reason')
            ->add('status',ChoiceType::class, [
                'choices' => [
                    'Active' => 'Active',
                    'Pending' => 'Pending',
                    'Inactive' => 'Inactive',
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Description de votre entreprise',
                    'class'=>"w-full"
                ],
                'row_attr'=>[
                   'class'=>"col-span-full"
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => "Enregistrer",
                'row_attr'=>[
                    'class'=>"col-span-full text-center"
                ]
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', IntegerType::class)
            ->add('published', CheckboxType::class,[
                'required' => false,
            ])
            ->add('stock', IntegerType::class)
            ->add('tva', ChoiceType::class, [
                'label' => 'Taux de TVA',
                'attr' => [
                    'placeholder' => 'Choisissez un taux de TVA',
                ],
                'choices' => array_flip(Product::TVA)
            ])
            ->add('thumbnailFile', VichImageType::class,[
                'allow_delete' => false,
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('supplier', EntityType::class, [
                'class' => Supplier::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [
                'label' => "Enregistrer",
                'row_attr' => [
                    'class' => "col-span-full text-center"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

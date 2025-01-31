<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => "name",
                'placeholder' => "Selectionnez une catégorie",
                'required' => true,
            ])
            ->add('description')
            ->add('price')
            ->add('imageFile', VichFileType::class,[
                'required' => !$options['is_edit'],
                'label' => $options['is_edit'] ? 'Modifier l\'image (optionnel)' : 'Télécharger une image'
            ])
            ->add('ishomepage', CheckboxType::class, [
                'label' => 'Mettre en vedette',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'is_edit' => true,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'attr' => ['placeholder' => 'Titre annonces ?'],
            ])
            ->add('content',TextareaType::class,[
                'attr' => ['placeholder' => 'Contenu annonces ?'],
            ])
            ->add('categories',EntityType::class,[
                'class'=>Categories::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}

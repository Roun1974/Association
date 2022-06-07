<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
Use FOS\CKEditorBundle\Form\Type\CKEditorType;
use phpDocumentor\Reflection\PseudoTypes\False_;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'attr' => ['placeholder' => 'Titre annonces ?'],
            ])
            ->add('nickname',TextType::class,[
                'attr' => ['placeholder' => 'Votre pseudo ?'],
            ])
            ->add('content',CKEditorType::class,[
                'attr' => ['placeholder' => 'Contenu annonces ?'],
            ])
            ->add('categories',EntityType::class,[
                'class'=>Categories::class
            ])
            // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la base de données (mapped à false)
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Projet;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire')

            ->add('projet', null,[
                'class' => Projet::class,
                'choice_label' => 'nom'
            ])
            ->add('utilisateur', null,[
                'class' => Utilisateur::class,
                'choice_label' => 'prenom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}

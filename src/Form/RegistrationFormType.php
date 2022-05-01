<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'attr' => ['placeholder' => 'Votre nom ?'],
            ])
            ->add('prenom', null, [
                'attr' => ['placeholder' => 'Votre prénom ?'],
            ])
            ->add('telephone', null, [
                'attr' => ['placeholder' => 'Votre numéro de téléphone ?'],
            ])
            ->add('rue', null, [
                'attr' => ['placeholder' => 'Votre rue ?'],
            ])
            ->add('codePostal', null, [
                'attr' => ['placeholder' => 'Votre code postal ?'],
            ])
            ->add('ville', null, [
                'attr' => ['placeholder' => 'Votre ville ?'],
            ])
            ->add('pays', null, [
                'attr' => ['placeholder' => 'Votre pays ?'],
            ])
            ->add('email', null, [
                'attr' => ['placeholder' => 'Votre mail ?'],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Votre mot de passe ?',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                            'placeholder' => 'Votre mot de passe ?'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe est trop court, veuiller saisir {{ limit }} caractères minimum',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('verificationPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Validation mot de passe',
                'attr' => ['placeholder' => 'Confirmer votre mot de passe'],
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}

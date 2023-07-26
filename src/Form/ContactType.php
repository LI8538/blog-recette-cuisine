<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Votre nom'],
                'label' => 'Quel est votre nom ?',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit contenir au moins {{ limit }} caractères',
                        'max' => 50,
                        'maxMessage' => 'Votre nom doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ]) // Terminé
            ->add('Prenom', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Votre prénom'],
                'label' => 'Quel est votre prénom ?',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre prénom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit contenir au moins {{ limit }} caractères',
                        'max' => 50,
                        'maxMessage' => 'Votre prénom doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ]) // Terminé
            ->add('Sujet', ChoiceType::class, [
                'choices'  => [
                    'Informations' => 'Informations',
                    'Partenariat' => 'Partenariat',
                    'Autre' => 'Autre',
                ],
                'label' => 'À quel sujet vous nous contactez ?',
            ]) // Terminé
            ->add('Email', EmailType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Votre adresse email'],
                'label' => 'Saisissez votre adresse email',
                'constraints' => [
                    new Email([
                        'message' => 'Veuillez saisir une adresse email valide'
                    ])
                ]
            ]) // Terminé
            ->add('Telephone', TelType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Votre numéro de téléphone'],
                'label' => 'Avez-vous un numéro de téléphone ?',
                'constraints' => [
                    new Regex([
                        'pattern' => '/[+]{1}[3]{2}[1-7]{1}[0-9]{8}/',
                        'message' => 'Veuillez saisir un numéro de téléphone valide'
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre numéro de téléphone doit contenir au moins {{ limit }} caractères',
                        'max' => 15,
                        'maxMessage' => 'Votre numéro de téléphone doit contenir au maximum {{ limit }} caractères',
                    ]),
                ]
            ]) // Terminé
            ->add('Message', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Rédigez votre message juste ici',
                    'rows' => 10
                ],
                'label' => 'Rédigez votre message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'écrire un message',
                    ]),
                    new Length([
                        'min' => 100,
                        'minMessage' => 'Votre message doit contenir au moins {{ limit }} caractères',
                        'max' => 2000,
                        'maxMessage' => 'Votre message doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ]) // Terminé
            ->add('Envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success rounded-pill'],
            ]) // Terminé
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

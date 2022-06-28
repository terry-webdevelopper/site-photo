<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                "attr"=>[
                    "class"=>"contact-form-text",
                    "placeholder"=>"email"
                ],
                "label"=>false
            ])
            ->add('nom', null, [
                "attr"=>[
                    "class"=>"contact-form-text",
                    "placeholder"=>"nom"
                ],
                "label"=>false
            ])
            ->add('prenom', null, [
                "attr"=>[
                    "class"=>"contact-form-text",
                    "placeholder"=>"prénom"
                ],
                "label"=>false
            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    "attr"=>[
                        "class"=>"contact-form-text",
                        "placeholder"=>"mot de passe"
                    ],
                    "label"=>false,
                    "constraints" => [
                        new NotBlank(['message' => "Veuillez entrer un mot de passe"]),
                        new Length([
                            'min' => 6,
                            'minMessage' => "Votre mot de passe doit comporter au moins {{ limit }} caractères",
                            'max' => 4096
                        ]),
                    ]
                ],
                'second_options' => [
                    "attr"=>[
                        "class"=>"contact-form-text",
                        "placeholder"=>"confirmer mot de passe"
                    ],
                    "label"=>false
                ],
                'invalid_message' => "Les champs de mot de passe doivent correspondre"
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J’accepte les Conditions Générales d’Utilisation',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les termes',
                    ]),
                ],
            ])
            ->add("submit", SubmitType::class,[
                'row_attr' => ['class' => 'contact-form-ac'],
                "attr"=> ['class'=>'contact-form-btn-ac'],
                "label"=>"S'INSCRIRE"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

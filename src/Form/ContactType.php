<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // écrire les éléments dont on a besoin
        $builder
            ->add('nom', null, [
                "attr"=>[
                    "class"=>"contact-form-text",
                    "placeholder"=>"nom"
                ],
                "label"=>false
            ])
            ->add('email', EmailType::class,[
                "attr"=>[
                    "class"=>"contact-form-text",
                    "placeholder"=>"email"
                ],
                "label"=>false
            ])
            ->add('message', TextareaType::class,[
                "attr"=> ['class'=>'contact-form-text',
                "placeholder"=>"message"],
                "label"=>false
            ])
            ->add('captacha',CaptchaType::class,[
                "label"=>false,
                'invalid_message'=>'captcha incorrect',
                'height'=>64.7,
                'row_attr' => ['class' => 'contact-form-ac'],
                "attr"=> ['class'=>'form-control', 
                        'placeholder'=>'captcha'],
                        "label"=>false,
                             
            ])
            ->add('submit', SubmitType::class,[
                'row_attr' => ['class' => 'contact-form-ac'],
                "attr"=> ['class'=>'contact-form-btn-ac'],
                "label"=>"ENVOYER"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mobile', TextType::class, [
                'required'=>true,
                'constraints'=>[
                    new NotBlank([
                        'message' => 'شماره تماس اجباری است',
                    ]),
                    new Length([
                        'min' => 11,
                        'exactMessage' => 'شماره تماس را بصورت صحیح وارد کنید',
                        'max' => 11,
                    ]),
                    new Regex([
                        'pattern'=>'/^09\d{1,2}\d{8}$/',
                        'message'=>'شماره تماس خود را با پیش شماره 09 شروع کنید'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname' , TextType::class , [
                'required'=>true,
                'constraints'=>[
                    new NotBlank([
                        'message' => 'لطفا نام و نام خانوادگی خود را وارد کنید',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'حداقل {{ limit }} کاراکتر',
                        'max' => 100,
                        'maxMessage' => 'حداکثر {{ limit }} کاراکتر',
                    ]),
                ]
            ])
            ->add('mobile' , TextType::class , [
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
            ->add('email' , EmailType::class , [
                'constraints'=>[
                    new Length([
                        'max' => 150,
                        'maxMessage' => 'حداکثر {{ limit }} کاراکتر',
                    ]),
                ]
            ])
            ->add('birthday' , BirthdayType::class , [
                'view_timezone'=>'Asia/Tehran'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'رمز عبور شما همخوانی ندارد .',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'لطفا یک رمز عبور وارد کنید',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'رمز عبور شما باید حد اقل شامل {{ limit }} کاراکنر بزرگ و کوچک باشد',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern'=>'/(.*[A-Z].*)/',
                        'message'=>'حداقل یک کاراکتر بزرگ الزامی است'
                    ])
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

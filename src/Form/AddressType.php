<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state', ChoiceType::class,[
                'required'=>true,
                'attr' => ['id' => 'state'],
            ])
            ->add('city', ChoiceType::class,[
                'required'=>true,
                'attr' => ['id' => 'city'],
            ])
            ->add('address', TextType::class,[
                'required'=>true,
                'constraints'=>[
                    new NotBlank([
                        'message' => 'لطفا آدرس خود را وارد کنید',
                    ]),
                    new Length([
                        'min' => 20,
                        'minMessage' => 'حداقل {{ limit }} کاراکتر',
                        'max' => 200,
                        'maxMessage' => 'حداکثر {{ limit }} کاراکتر',
                    ]),
                ]
            ])
            ->add('postalcode',  TextType::class , [
                'required'=>true,
                'constraints'=>[
                    new NotBlank([
                        'message' => 'لطفا کد پستی خود را وارد کنید',
                    ]),
                    new Length([
                        'min' => 10,
                        'exactMessage' => 'حتما {{ limit }} کاراکتر',
                        'max' => 10,
                    ]),
                ]
            ])
        ;

        // disable state and city validation because of not unique value
        $builder->get('state')->resetViewTransformers();
        $builder->get('city')->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,

        ]);
    }
}

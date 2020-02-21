<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Assert;

class AddressType extends AbstractType
{
    
    /**
     * Address Type form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voie', TextType::class, [
                'invalid_message' => 'voie is invalid',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('number', IntegerType::class, [
                'invalid_message' => 'number is invalid',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('postal_code', TextType::class, [
                'invalid_message' => 'postal code is invalid',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('city', TextType::class, [
                'invalid_message' => 'city is invalid',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('country', TextType::class, [
                'invalid_message' => 'country is invalid',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('ip', TextType::class, [
                'invalid_message' => 'ip is invalid',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('save', SubmitType::class)
        ;
    }
}
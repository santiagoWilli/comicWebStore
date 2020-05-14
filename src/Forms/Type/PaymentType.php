<?php


namespace App\Forms\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PaymentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('cardNumber', NumberType::class, [
                'label' => "Número de la tarjeta",
            ])
            ->add('cardholderName', TextType::class, [
                'label' => "Nombre completo del titular",
            ])
            ->add('expirationDate', DateType::class, [
                'label' => "Fecha de caducidad",
                'widget' => 'single_text',
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes',
                ]
            ])
            ->add('cardType', ChoiceType::class, [
                'label' => "Tarjeta",
                'choices' => array(
                    'Visa' => 'Visa',
                    'Mastercard' => 'Mastercard',
                    'American Express' => 'American Express',
                ),
            ])
            ->add('csv', NumberType::class, [
                'label' => "CSV",
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => "Pagar",
            ]);
    }
}
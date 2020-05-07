<?php


namespace App\Forms\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateComicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Título",
            ])
            ->add('description', TextType::class, [
                'label' => "Descripción",
            ])
            ->add('price', MoneyType::class, [
                'label' => "Precio (€)",
            ])
            ->add('publisher', TextType::class, [
                'label' => "Editorial",
                'required' => false,
            ])
            ->add('genre', TextType::class, [
                'label' => "Género/s (separado por ';')",
            ])
            ->add('author', TextType::class, [
                'label' => "Autor/a",
                'required' => false,
            ])
            ->add('stock', NumberType::class, [
                'label' => "Stock",
            ])
            ->add('release_date', DateType::class, [
                'label' => "Fecha de lanzamiento",
                'required' => false,
                'widget' => 'single_text',
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Dia',
                ]
            ])
            ->add('image', FileType::class, [
                'label' => "Imagen",
            ])
            ->add('save', SubmitType::class, [
                'label' => "Guardar",
            ]);
    }
}
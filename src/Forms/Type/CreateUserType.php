<?php


namespace App\Forms\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nombre",
            ])
            ->add('lastName', TextType::class, [
                'label' => "Apellidos",
            ])
            ->add('role', TextType::class, [
                'label' => "Rol",
            ])
            ->add('category', TextType::class, [
                'label' => "Categoría",
            ])
            ->add('password', TextType::class, [
                'label' => "Contraseña",
            ])
            ->add('email', EmailType::class, [
                'label' => "Email",
            ])
            ->add('birthDate', TextType::class, [
                'label' => "Fecha de nacimiento",
                'required' => false,
            ])
            ->add('profilePicture', FileType::class, [
                'label' => "Foto de perfil",
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => "Añadir",
            ]);
    }
}
<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
              'label' => 'Votre prénom',
              'constraints' => new Length(null,3, 50),
              'attr' => [
                'placeholder' =>'Saisir votre prénom'
              ]
            ])
            ->add('lastname', TextType::class, [
              'label' => 'Votre nom',
              'constraints' => new Length(null, 3, 50),
              'attr' => [
                'placeholder' =>'Saisir votre nom'
              ]
            ])
            ->add('email', EmailType::class, [
              'label' => 'Votre e-mail',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 55,
                ]),
              'attr' => [
                'placeholder' =>'Saisir votre e-mail'
              ]
            ])
            ->add('password', RepeatedType::class, [
              'type' => PasswordType::class,
              'invalid_message' => 'La saisie des mots de passe ne correspondent pas',
              'label' => 'Votre mot de passe',
              'first_options' => [
                  'label' => 'Mot de passe',
                  'attr' => ['
                    placeholder' => 'Votre mot de passe'],
              ],
              'second_options' => [
                'label' => 'Confirmez votre mot de passe',
                'attr' => ['
                    placeholder' => 'Confirmez votre mot de passe'],]
            ])
            ->add('submit', SubmitType::class, [
              'label' => "S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

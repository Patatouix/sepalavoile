<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom :',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom :'
            ])
            ->add('email', EmailType::class)
            ->add('numTel', TelType::class, [
                'label' =>'Numéro de téléphone'
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo :'
            ])
            ->add('adresse', TextType::class, [
                'label' => 'N° et nom de rue :'
            ])
            ->add('codePostal')
            ->add('ville', TextType::class, [
                'label' => 'Ville :'
            ])
            ->add('isVerified', CheckboxType::class, [
                'label'    => 'Compte vérifié',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Vos mots de passes ne sont pas identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Saississez votre mot de passe'],
                'second_options' => ['label' => 'Re-saississez votre mot de passe'],
            ])            
            // ->add('roles', ChoiceType::class, [
            //     'label' => 'Type de droit',
            //     'choices' => [
            //         'Administrateur' => 'ROLE_ADMIN',
            //         'Utilisateur' => 'ROLE_USER',
            // ],
            // ])
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('avatar')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

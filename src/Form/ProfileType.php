<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\User;
use App\Form\Type\MediaEntityFrontType;
use App\Form\Type\MediaEntityType;
use App\Repository\MediaRepository;
use Doctrine\ORM\Query\AST\Join as ASTJoin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\Query\Expr\Join;

class ProfileType extends AbstractType
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
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo :',
                'required' => false
            ])
            ->add('adresse', TextType::class, [
                'label' => 'N° et nom de rue :',
                'required' => false
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code Postal :',
                'required' => false
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville :',
                'required' => false
            ])
            ->add('numTel', TelType::class, [
                'label' =>'Numéro de téléphone :',
                'required' => false
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

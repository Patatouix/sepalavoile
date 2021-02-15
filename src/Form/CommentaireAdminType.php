<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu', TextareaType::class, [
                'disabled' => true,
            ])
            ->add('article', EntityType::class, [
                'choice_label' => 'title',
                'class' => Article::class,
                'disabled' => true,
            ])
            ->add('user', EntityType::class, [
                'choice_label' => 'nomComplet',
                'class' => User::class,
                'disabled' => true,
                'label' => 'Utilisateur'
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Commentaire publié',
                'required' => false,
            ])
            ->add('createdAt', DateTimeType::class, [
                'disabled' => true,
                'label' => 'Date de création'
            ])
            ->add('updatedAt', DateTimeType::class, [
                'disabled' => true,
                'label' => 'Date de modification'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}

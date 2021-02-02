<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleCategorie;
use App\Entity\Media;
use App\Form\Type\MediaEntityType;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article :',
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Rédiger article :',
                'config' => [
                    'uiColor' => "#dee2e6",
                    'toolbar' => "full",
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur de l\'article :',
            ])
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('nbVues')
            // ->add('publishedDateStart')
            // ->add('publishedDateEnd')
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Cocher si l\'article doit être publié ?',
                'required' => false,
            ])
            ->add('articleCategories', EntityType::class, [
                'label' => 'Catégorie article :',
                'choice_label' => 'name',
                'class' => ArticleCategorie::class,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('medias', MediaEntityType::class, [
                'label' => 'Médias associés :',
                'class' => Media::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\MediaCategory;
use App\Repository\MediaCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'label' => 'Fichier :',
                'required' => false
            ])
            // ->add('nom', TextType::class, [
            //     'label' => 'Nom du fichier :',
            // ])
            ->add('url', TextType::class, [
                'label' => 'URL de la vidéo YouTube :',
                'required' => false
            ])
            ->add('description', TextType::class, [
                'label' => 'Description du média (texte alternatif) :',
                'required' => false
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre du média :',
                'required' => false
            ])
            ->add('facebookLink', TextType::class, [
                'label' => 'Lien de partage FaceBook :',
                'required' => false
            ])
            // ->add('createdAt')
            // ->add('updatedAt')
            // ->add('type')
            // ->add('submit', SubmitType::class)
            // ->add('produits')
            ->add('mediaCategory', EntityType::class, [
                'label' => 'Catégorie :',
                'choice_label' => function(?MediaCategory $mediaCategory) {
                    return $mediaCategory->getName();
                },
                'class' => MediaCategory::class,
                // 'query_builder' => function (MediaCategoryRepository $mediaCategoryRepository) {
                //     return $mediaCategoryRepository->createQueryBuilder('u')
                //         ->where('u.name LIKE :name')
                //         ->setParameter('name', '%"ROLE_ADMIN"%');
                // },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}

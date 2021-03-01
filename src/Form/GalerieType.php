<?php

namespace App\Form;

use App\Entity\Galerie;
use App\Entity\GalerieCategorie;
use App\Entity\Media;
use App\Form\Type\MediaEntityType;
use App\Repository\GalerieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('medias', MediaEntityType::class, [
                'label' => 'Médias associés :',
                'class' => Media::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'by_reference' => false,
            ])
            // ->add('galerie', EntityType::class, [
            //     'label' => 'Médias associés : :',
            //     'choice_label' => function(?Galerie $galerie) {
            //         return $galerie->getId();
            //     },
            //     'class' => Galerie::class,
            //     'query_builder' => function (GalerieRepository $galerieRepository) {
            //         return $galerieRepository->createQueryBuilder('u')
            //             ->where('u.id LIKE :id')
            //             ->setParameter('id', '%"ROLE_ADMIN"%');
            //     },
            // ])
            ->add('nom', TextType::class, [
                'label' => 'Nom de la galerie :',
            ])
            ->add('descritpion', TextType::class, [
                'label' => 'Description de la galerie :',
            ])
            ->add('galerieCategorie', EntityType::class, [
                'label' => 'Catégorie galerie :',
                'choice_label' => 'nom',
                'class' => GalerieCategorie::class,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Galerie::class,
        ]);
    }
}

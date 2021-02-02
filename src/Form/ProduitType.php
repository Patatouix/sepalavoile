<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Produit;
use App\Entity\ProduitType as ProduitTypeEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Type\MediaEntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('debutVente')
            ->add('finVente')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('prix')
            ->add('limiteParticipation')
            ->add('duree')
            ->add('produitType', EntityType::class, [
                'label' => 'Type de produit :',
                'choice_label' => 'nom',
                'class' => ProduitTypeEntity::class
            ])
            ->add('medias', MediaEntityType::class, [
                'label' => 'Médias associés :',
                'class' => Media::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'by_reference' => false,
            ])
            //->add('createdAt')
            //->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}

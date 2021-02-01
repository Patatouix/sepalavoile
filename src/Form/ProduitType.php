<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\ProduitType as ProduitTypeEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('debutPublication')
            ->add('finPublication')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('prix')
            ->add('objectif')
            ->add('duree')
            ->add('produitType', EntityType::class, [
                'label' => 'Type de produit :',
                'choice_label' => 'nom',
                'class' => ProduitTypeEntity::class
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

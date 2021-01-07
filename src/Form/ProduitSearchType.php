<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ProduitType;
use App\Data\ProduitSearchData;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProduitSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produitTypes', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => ProduitType::class,
                'choice_label' => 'nom',
                'choice_value' => 'slug',
                'expanded' => true,
                'multiple' => true
            ])
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('min', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ]
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProduitSearchData::class,
            //GET pour que les paramètres passent dans l'URL et qu'on puisse partager une recherche
            'method' => 'GET',
            //pas de problème de cross-scripting ici
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        //pour enlever le préfixe et avoir une URL la plus propre possible
        return '';
    }
}

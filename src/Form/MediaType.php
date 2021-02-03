<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('nom')
            //->add('url')
            //->add('description')
            //->add('titre')
            //->add('facebookLink')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('type')
            //->add('submit', SubmitType::class)
            //->add('produits')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}

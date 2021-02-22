<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Partners;
use App\Form\Type\MediaEntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom :',
            ])
            ->add('webSite', TextType::class, [
                'label' => 'Site :',
            ])
            ->add('media', MediaEntityType::class, [
                'label' => 'Médias associés :',
                'class' => Media::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un fichier',
                'required' => false,

                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partners::class,
        ]);
    }
}

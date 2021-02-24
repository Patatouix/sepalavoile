<?php

namespace App\Form;

use App\Entity\Achat;
use App\Entity\Media;
use App\Form\Type\MediaEntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('medias', MediaEntityType::class, [
                'label' => 'Fichiers associés :',
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
            'data_class' => Achat::class,
        ]);
    }
}

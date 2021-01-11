<?php

namespace App\Form;

use App\Entity\Partners;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('webSite')
            ->add('media', ChoiceType::class, [
                'label' => 'Partenaire :',
                'choice_label' => 'media',
                // 'class' => PartnersType::class,
                // 'multiple' => true,
                // 'expanded' => true,
                // 'by_reference' => false,
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

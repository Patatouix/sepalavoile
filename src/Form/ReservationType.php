<?php

namespace App\Form;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantitePlaces', IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => ['min' => 0]
            ])
            ->add('creneau_id', IntegerType::class, [
                'label' => false,
                'attr' => ['style' => 'display: none']
            ])
        ;
    }
}

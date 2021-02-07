<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet')
            ->add('contenu')
            ->add('destinataire', EntityType::class, [
                'label' => 'Destinataire :',
                'choice_label' => function(?User $user) {
                    return $user->getNomComplet() . ' (' . $user->getEmail() . ')';
                },
                'class' => User::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}

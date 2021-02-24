<?php

namespace App\Form;

use App\Entity\Media;
use App\Repository\MediaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Security;

class ReservationProfileType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();

        $builder
            ->add('feedback', TextareaType::class, [
                'label' => 'Donnez votre avis sur l\'événement :',
                'attr' => [
                    'rows' => 3
                ]
            ])
            ->add('medias', EntityType::class, [
                'label' => 'Photos de l\'événement :',
                'class' => Media::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'by_reference' => false,
                'choices' => $user->getMedias()
            ])
        ;
    }
}
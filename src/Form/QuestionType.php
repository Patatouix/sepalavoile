<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Sondage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function PHPSTORM_META\type;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('help')
            ->add('sondage', EntityType::class, [
                'class'     => Sondage::class,
                'choice_value' => 'id',
                'choice_label' => 'titre'
                //'mapped'    => false,
                //'choice_value'    => function(Sondage $sondage = null) {
                //    if ($sondage) {
                //      return $this->encoder->encode($sondage->getId());
                //  }
                //},
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Training;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'team',
                EntityType::class,
                array(
                    'class' => Team::class,
                    'choice_label' => 'name',
                    'label' => "Équipe"
                )
            )
            ->add(
                'timeStart',
                TimeType::class,
                array(
                    'label' => "Début de l'entraînement"
                )
            )
            ->add(
                'timeEnd',
                TimeType::class,
                array(
                    'label' => "Fin de l'entraînement"
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}

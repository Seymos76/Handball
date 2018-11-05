<?php

namespace App\Form;

use App\Entity\Meeting;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'games',
                CollectionType::class,
                array(
                    'entry_type' => GameType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'required' => false,
                    'attr' => array(
                        'class' => "game_collection_entry"
                    )
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
        ]);
    }
}

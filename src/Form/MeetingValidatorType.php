<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 28/10/18
 * Time: 19:09
 */

namespace App\Form;


use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

class MeetingValidatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'games',
                CollectionType::class,
                array(
                    'entry_type' => ResultType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'prototype' => true,
                    'required' => true,
                    'constraints' => array(

                    ),
                    'attr' => array(
                        'class' => "game_collection_entry"
                    )
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class
        ]);
    }
}

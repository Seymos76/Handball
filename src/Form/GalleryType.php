<?php

namespace App\Form;

use App\Entity\Gallery;
use App\Form\DataTransformer\MultipleFilesToImagesTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    private $transformer;

    public function __construct(MultipleFilesToImagesTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => "Nom de la galerie"
                )
            )
            ->add(
                'images',
                CollectionType::class,
                array(
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'required' => false,
                    'label' => "Ajoutes les images",
                    'prototype' => true,
                    'attr' => array(
                        'class' => "image_collection_entry"
                    )
                )
            )
            //->get('images')->addModelTransformer($this->transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }
}

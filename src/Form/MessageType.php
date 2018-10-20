<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => "Nom complet"
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'label' => "Votre e-mail"
                )
            )
            ->add(
                'subject',
                TextType::class,
                array(
                    'required' => false,
                    'label' => "Sujet de votre message"
                )
            )
            ->add(
                'message',
                TextareaType::class,
                array(
                    'label' => "Votre message"
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}

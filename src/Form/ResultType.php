<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 20/10/18
 * Time: 18:42
 */

namespace App\Form;


use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'winner',
                TextType::class,
                array(
                    'label' => "Vainqueur",
                    'required' => true
                )
            )
            ->add(
                'winnerScore',
                IntegerType::class,
                array(
                    'label' => "Score du vainqueur",
                    'required' => true
                )
            )
            ->add(
                'looser',
                TextType::class,
                array(
                    'label' => "Équipe vaincue",
                    'required' => true
                )
            )
            ->add(
                'looserScore',
                IntegerType::class,
                array(
                    'label' => "Score de l'équipe vaincue",
                    'required' => true
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => Game::class
            )
        );
    }
}
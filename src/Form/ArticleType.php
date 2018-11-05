<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Gallery;
use App\Form\DataTransformer\ArticleFileToArrayTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    private $transformer;

    public function __construct(ArticleFileToArrayTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                array(
                    'label' => "Titre de l'article"
                )
            )
            ->add(
                'summary',
                TextareaType::class,
                array(
                    'required' => false,
                    'label' => "Résumé de l'article (si non rempli, sera généré automatiquement"
                )
            )
            ->add(
                'content',
                TextareaType::class,
                array(
                    'label' => "Contenu de votre article"
                )
            )
            ->add(
                'image',
                ImageType::class,
                array(
                    'label' => "Image à la une (facultative)",
                    'data_class' => null,
                    'required' => false,
                )
            )
            ->get('image')->addModelTransformer($this->transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

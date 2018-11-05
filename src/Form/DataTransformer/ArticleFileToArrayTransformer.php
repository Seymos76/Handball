<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 19/10/18
 * Time: 19:53
 */

namespace App\Form\DataTransformer;


use App\Service\Image\Uploader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ArticleFileToArrayTransformer implements DataTransformerInterface
{
    private $uploader;
    private $container;

    public function __construct(Uploader $uploader, ContainerInterface $container)
    {
        $this->uploader = $uploader;
        $this->container = $container;
    }

    public function transform($array)
    {
        // TODO: Implement transform() method.
    }

    public function reverseTransform($file)
    {
        if (!$file['filename']) {
            throw new TransformationFailedException(sprintf('File was not found...', $file));
        }
        if ($file['filename'] === null) {
            return;
        }
        $filename = $this->uploader->upload($file['filename'], $this->container->getParameter('hb.article_image'));
        return $filename;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 18/10/18
 * Time: 10:09
 */

namespace App\Manager;


use App\Entity\Slide;
use Cocur\Slugify\Slugify;

class SlideManager extends ImageManager
{
    public function createSlide(array $formData)
    {
        $slide = new Slide();
        $slugger = new Slugify();
        $slide->setName($formData['name']);
        $slide->setSlug($slugger->slugify($formData['name']));
        $filename = $this->uploader->upload($formData['image'], $this->container->getParameter('hb.slide_image'), $slide->getSlug());
        $slide->setImage($filename);
        $this->update($slide);
        return $slide;
    }

    public function updateSlide(array $formData, Slide $slide)
    {
        if ($formData['image'] !== null) {
            $filename = $this->uploader->upload($formData['image'], $this->container->getParameter('hb.slide_image'));
            $slide->setImage($filename);
        }
        $this->update($slide);
        return $slide;
    }
}
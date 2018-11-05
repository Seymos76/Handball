<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 17/10/18
 * Time: 17:57
 */

namespace App\Manager;


use App\Entity\Gallery;

class GalleryManager extends ImageManager
{
    public function createGallery(Gallery $gallery)
    {
        $gallery->setSlug();
        $gallery->setPath();
        $files = $gallery->getImages();
        $images = [];
        foreach ($files as $k => $v) {
            $image = $this->createImage($v['filename']);
            $filename = $this->uploadFile($v['filename'], $this->container->getParameter('hb.gallery_image').'/'.$gallery->getPath());
            $image->setFilename($filename);
            array_push($images, $image);
        }
        $gallery->resetImages();
        foreach ($images as $image) {
            $gallery->addImage($image);
        }
        $this->update($gallery);
    }
}
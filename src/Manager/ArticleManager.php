<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 19/10/18
 * Time: 19:45
 */

namespace App\Manager;


use App\Entity\Article;
use Cocur\Slugify\Slugify;

class ArticleManager extends GalleryManager
{
    public function createArticle(Article $article)
    {
        $slugger = new Slugify();
        $article->setSlug($slugger->slugify($article->getTitle()));
        if ($article->getSummary() === null) {
            $article->setSummary(substr($article->getContent(),0,200));
        }
        $this->update($article);
        return $article;
    }
}
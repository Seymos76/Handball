<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use App\Service\Blog\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route(path="/galerie/{page}",  name="galleries", requirements={"page"="\d+"})
     * @param GalleryRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function galleries(GalleryRepository $repository, int $page = 1, Pagination $pagination)
    {
        $perPage = 1;
        $allGalleries = $repository->findAll();
        $nbPages = $pagination->getTotalPages($allGalleries, $perPage);
        $limit = $pagination->getLimit($page, $perPage);
        $offset = $pagination->getOffset($limit, $perPage);
        $galleries = $repository->findBy(
            [],
            ['id' => 'DESC'],
            $limit,
            $offset
        );
        return $this->render(
            'gallery/galleries.html.twig', [
                'galleries' => $galleries,
                'per_page' => $perPage,
                'nb_pages' => $nbPages,
                'page' => $page
            ]
        );
    }

    /**
     * @Route("/galerie/{slug}", name="gallery")
     */
    public function gallery(string $slug, GalleryRepository $repository)
    {
        return $this->render(
            'gallery/gallery.html.twig', [
                'gallery' => $repository->findOneBy(
                    array(
                        'slug' => $slug
                    )
                )
            ]
        );
    }
}

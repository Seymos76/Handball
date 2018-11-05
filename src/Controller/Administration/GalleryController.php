<?php

namespace App\Controller\Administration;

use App\Entity\Gallery;
use App\Entity\Image;
use App\Form\GalleryType;
use App\Form\ImageType;
use App\Manager\GalleryManager;
use App\Repository\GalleryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gallery")
 */
class GalleryController extends AbstractController
{
    /**
     * @Route("/", name="gallery_index", methods="GET")
     */
    public function index(GalleryRepository $galleryRepository): Response
    {
        return $this->render('administration/gallery/index.html.twig', ['galleries' => $galleryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="gallery_new", methods="GET|POST")
     */
    public function new(Request $request, GalleryManager $galleryManager): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galleryManager->createGallery($gallery);
            $this->addFlash('success',"Galerie ajoutée !");
            return $this->redirectToRoute('gallery_index');
        }

        return $this->render('administration/gallery/new.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_show", methods="GET")
     * @ParamConverter("gallery", class="App\Entity\Gallery")
     */
    public function show(Request $request, Gallery $gallery, GalleryManager $galleryManager): Response
    {
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $galleryManager->createImage($form->getData()['filename']);
            $filename = $galleryManager->uploadFile($form->getData()['filename'], $this->getParameter('hb.gallery_image')."/".$gallery->getPath());
            $image->setFilename($filename);
            $gallery->addImage($image);
            $galleryManager->update($image);
            $galleryManager->update($gallery);
            $this->addFlash('success',"Image ajoutée !");
            return $this->redirectToRoute('gallery_show', ['id' => $gallery->getId()]);
        }
        return $this->render('administration/gallery/show.html.twig', ['gallery' => $gallery, 'form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/edit", name="gallery_edit", methods="GET|POST")
     */
    public function edit(Request $request, Gallery $gallery): Response
    {
        $form = $this->createForm(GalleryType::class, $gallery);
        $gallery_images_count = count($gallery->getImages());
        dump($gallery_images_count);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_count = $gallery->getImages();
            dump($new_count);
            die;
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallery_edit', ['id' => $gallery->getId()]);
        }

        return $this->render('administration/gallery/edit.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/add-image-on-gallery", name="add_image_on_gallery", methods="POST")
     * @param Request $request
     * @param GalleryManager $galleryManager
     */
    public function addImageToGallery(Request $request, GalleryManager $galleryManager)
    {
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $galleryManager->createImage($form->getData()['filename']);
            $gallery = $galleryManager->getManager()->getRepository(Gallery::class)->find($request->request->get('add_image_on_gallery_id'));
            $filename = $galleryManager->uploadFile($form->getData()['filename'], $this->getParameter('hb.gallery_image')."/".$gallery->getPath());
            $image->setFilename($filename);
            $gallery->addImage($image);
            $galleryManager->update($image);
            $galleryManager->update($gallery);
            $this->addFlash('success',"Image ajoutée !");
            return $this->redirectToRoute('gallery_show', ['id' => $gallery->getId()]);
        }
        return $this->render(
            'administration/gallery/_add_image.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route(path="/remove-image-from-gallery", name="remove_image_from_gallery", methods="POST")
     * @param Request $request
     * @param GalleryManager $galleryManager
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeImageFromGallery(Request $request, GalleryManager $galleryManager)
    {
        if ($request->isMethod("POST")) {
            $image = $galleryManager->getManager()->getRepository(Image::class)->find($request->request->get('image_id'));
            $gallery = $galleryManager->getManager()->getRepository(Gallery::class)->find($request->request->get('gallery_id'));
            $gallery->removeImage($image);
            $galleryManager->removeImageFromApp($image, $this->getParameter('hb.gallery_image')."/".$gallery->getPath());
            $galleryManager->remove($image);
            $galleryManager->update($gallery);
            $this->addFlash('success',"Image supprimée de la galerie !");
            return $this->redirectToRoute('gallery_show', array('id' => $gallery->getId()));
        } else {
            return false;
        }
    }

    /**
     * @Route("/{id}", name="gallery_delete", methods="DELETE")
     */
    public function delete(Request $request, Gallery $gallery, GalleryManager $galleryManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gallery->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $images = $gallery->getImages();
            foreach ($images as $image) {
                $galleryManager->removeImageFromApp($image, $this->getParameter('hb.gallery_image')."/".$gallery->getPath());
                $gallery->removeImage($image);
            }
            $galleryManager->removeFolder($this->getParameter('hb.gallery_image')."/".$gallery->getPath());
            $em->remove($gallery);
            $em->flush();
            $this->addFlash('success',"Galerie supprimée !");
        }

        return $this->redirectToRoute('gallery_index');
    }
}

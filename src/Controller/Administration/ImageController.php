<?php

namespace App\Controller\Administration;

use App\Entity\Image;
use App\Form\ImageType;
use App\Manager\ImageManager;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/image")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/", name="image_index", methods="GET")
     */
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('administration/image/index.html.twig', ['images' => $imageRepository->findAll()]);
    }

    /**
     * @Route("/new", name="image_new", methods="GET|POST")
     */
    public function new(Request $request, ImageManager $imageManager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $imageManager->createImage($form->getData()['filename']);
            $imageManager->uploadFile($form->getData()['filename'], $this->getParameter('hb.single_image'), $image->getFilename());
            $image->setPath($this->getParameter('hb.single_image'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            $this->addFlash('success',"Image ajoutée !");
            return $this->redirectToRoute('image_index');
        }

        return $this->render('administration/image/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_show", methods="GET")
     */
    public function show(Image $image): Response
    {
        return $this->render('administration/image/show.html.twig', ['image' => $image]);
    }

    /**
     * @Route("/{id}/edit", name="image_edit", methods="GET|POST")
     */
    public function edit(Request $request, Image $image): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('image_edit', ['id' => $image->getId()]);
        }

        return $this->render('administration/image/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_delete", methods="DELETE")
     */
    public function delete(Request $request, Image $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
        }

        return $this->redirectToRoute('image_index');
    }
}

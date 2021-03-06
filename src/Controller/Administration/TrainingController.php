<?php

namespace App\Controller\Administration;

use App\Entity\Training;
use App\Form\TrainingType;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/training")
 */
class TrainingController extends AbstractController
{
    /**
     * @Route("/", name="training_index", methods="GET")
     */
    public function index(TrainingRepository $trainingRepository): Response
    {
        return $this->render('administration/training/index.html.twig', ['trainings' => $trainingRepository->findAll()]);
    }

    /**
     * @Route("/new", name="training_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $training = new Training();
        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($training);
            $em->flush();

            return $this->redirectToRoute('training_index');
        }

        return $this->render('administration/training/new.html.twig', [
            'training' => $training,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="training_show", methods="GET")
     */
    public function show(Training $training): Response
    {
        return $this->render('administration/training/show.html.twig', ['training' => $training]);
    }

    /**
     * @Route("/{id}/edit", name="training_edit", methods="GET|POST")
     */
    public function edit(Request $request, Training $training): Response
    {
        $form = $this->createForm(TrainingType::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('training_edit', ['id' => $training->getId()]);
        }

        return $this->render('administration/training/edit.html.twig', [
            'training' => $training,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="training_delete", methods="DELETE")
     */
    public function delete(Request $request, Training $training): Response
    {
        if ($this->isCsrfTokenValid('delete'.$training->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($training);
            $em->flush();
        }

        return $this->redirectToRoute('training_index');
    }
}

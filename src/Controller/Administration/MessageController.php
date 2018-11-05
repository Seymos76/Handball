<?php

namespace App\Controller\Administration;

use App\Entity\Message;
use App\Form\MessageType;
use App\Manager\MessageManager;
use App\Repository\MessageRepository;
use App\Service\Mail\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods="GET")
     */
    public function index(MessageRepository $messageRepository): Response
    {
        $allMessages = $messageRepository->findAll();
        $parents = $messageRepository->findParentMessages();
        dump($allMessages);
        dump($parents);
        die;
        return $this->render('administration/message/index.html.twig', ['messages' => $messageRepository->findAll()]);
    }

    /**
     * @Route("/new", name="message_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('administration/message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods="GET")
     */
    public function show(Message $message): Response
    {
        return $this->render('administration/message/show.html.twig', ['message' => $message]);
    }

    /**
     * @Route("/repondre/{id}", name="message_answer", methods={"GET|POST"})
     * @ParamConverter("message", class="App\Entity\Message")
     * @param Message $message
     * @param Request $request
     * @return Response
     */
    public function answer(Message $message, Request $request, Mailer $mailer, MessageManager $messageManager)
    {
        $answer = new Message();
        $user = $this->getUser();
        dump($user);
        $answer->setName($user->getFirstname()." ".$user->getLastname());
        $answer->setEmail($user->getEmail());
        $form = $this->createForm(MessageType::class, $answer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // record in db
            $message->addAnswer($answer);
            $messageManager->update($message);
            $messageManager->update($answer);
            $mailer->sendResponse($answer, $message);
            $this->addFlash('success',"Votre réponse a bien été envoyée à son destinataire.");
            return $this->redirectToRoute('meeting_show', ['id' => $message->getId()]);
        }
        return $this->render(
            'administration/message/answer.html.twig', [
                'form' => $form->createView(),
                'message' => $message
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="message_edit", methods="GET|POST")
     */
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_edit', ['id' => $message->getId()]);
        }

        return $this->render('administration/message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_delete", methods="DELETE")
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('message_index');
    }
}

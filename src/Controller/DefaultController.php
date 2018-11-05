<?php

namespace App\Controller;


use App\Entity\Message;
use App\Form\MessageType;
use App\Manager\MessageManager;
use App\Repository\GalleryRepository;
use App\Repository\GameRepository;
use App\Repository\MeetingRepository;
use App\Repository\SlideRepository;
use App\Repository\TrainingRepository;
use App\Service\Helpers\DateHelper;
use App\Service\Mail\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route(path="/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SlideRepository $slideRepository, MeetingRepository $meetingRepository, DateHelper $date)
    {
        $saturday = $date->getNextSaturday();
        $prev_saturday = $date->getPreviousSaturday();
        $prev_saturday = preg_replace("/-/", "/", $prev_saturday);
        $slides = $slideRepository->findAll();
        $last_meeting = $meetingRepository->findLastMeeting($prev_saturday);
        $next_meeting = $meetingRepository->findNextMeeting($saturday);
        dump($prev_saturday);
        dump($saturday);
        dump($last_meeting);
        dump($next_meeting);
        return $this->render(
            'default/index.html.twig', [
                'slides' => $slides,
                'next_meeting' => $next_meeting,
                'last_meeting' => $last_meeting
            ]
        );
    }

    /**
     * @Route(path="/entrainements", name="trainings")
     * @param TrainingRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function trainings(TrainingRepository $repository)
    {
        return $this->render(
            'default/trainings.html.twig', [
                'trainings' => $repository->findAll()
            ]
        );
    }

    /**
     * @Route(path="/contact", name="contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request, MessageManager $messageManager, Mailer $mailer)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // save message in db
            $messageManager->update($message);
            // send email
            $mailer->sendMessage($message);
            // flash message
            $this->addFlash('success',"Message envoyé !");
            // redirection
            return $this->redirectToRoute('contact');
        }
        return $this->render(
            'default/contact.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route(path="/mentions-legales", name="mentions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mentions()
    {
        return $this->render('default/mentions.html.twig');
    }
}
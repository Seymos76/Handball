<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 10/10/18
 * Time: 16:27
 */

namespace App\Service\Mail;


use App\Entity\Message;
use App\Entity\User;
use Twig\Environment;

class Mailer
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendMessage(Message $message)
    {
        $message_to_send = (new \Swift_Message("Nouveau message depuis le site associatif"))
            ->setTo("contact@forgesleseauxhandball.fr")
            ->setFrom($message->getEmail())
            ->setCharset("UTF-8")
            ->setBody(
                $this->twig->render(
                    'email/contact_message.html.twig',
                    array('message' => $message)
                ),
                'text/html'
            );
        $this->mailer->send($message_to_send);
        return true;
    }

    public function sendResponse(Message $response, Message $message)
    {
        $messageToSend = (new \Swift_Message($response->getSubject()))
            ->setTo($message->getEmail())
            ->setFrom($response->getEmail())
            ->setCharset("UTF-8")
            ->setBody(
                $this->twig->render(
                    'email/answer_from_admin.html.twig',
                    array(
                        'response' => $response,
                        'message' => $message
                    ),
                    'text/html'
                )
            );
        $this->mailer->send($messageToSend);
        return true;
    }

    public function sendAccountActivationCode(User $user)
    {
        $message = (new \Swift_Message("Activation de votre compte utilisateur"))
            ->setTo($user->getEmail())
            ->setFrom('no-reply@forgesleseauxhandball.fr')
            ->setCharset("UTF-8")
            ->setBody(
                $this->twig->render(
                    'email/account_activation.html.twig',
                    array('user' => $user)
                ),
                'text/html'
            );
        $this->mailer->send($message);
        return true;
    }
}
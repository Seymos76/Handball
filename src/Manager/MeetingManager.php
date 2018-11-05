<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 25/10/18
 * Time: 17:37
 */

namespace App\Manager;


use App\Entity\Game;
use App\Entity\Meeting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class MeetingManager extends EntityManager
{
    private $router;
    private $flashBag;

    public function __construct(EntityManagerInterface $manager, RouterInterface $router, FlashBagInterface $flashBag)
    {
        parent::__construct($manager);
        $this->router = $router;
        $this->flashBag = $flashBag;
    }

    public function saveMeetingGames(Meeting $meeting)
    {
        $games = $meeting->getGames();
        foreach ($games as $game) {
            $game->setMeeting($meeting);
            $this->update($game);
        }
        return true;
    }

    public function validateMeetingBeforeUpdate(FormInterface $form)
    {
        foreach ($form->getViewData()->getGames() as $game) {
            self::validateWinner($game);
            self::validateLooser($game);
            self::validateWinnerScore($game);
            self::validateLooserScore($game);
        }
        return $form;
    }

    public function validateWinner(Game $game)
    {
        if ($game->getWinner() === null || $game->getWinner() === "") {
            $this->flashBag->add('error',"Vous devez renseigner un vainqueur.");
            return $this->router->generate('meeting_show', ['id' => $game->getMeeting()->getId()]);
        }
    }
    public function validateLooser(Game $game)
    {
        if ($game->getLooser() === null || $game->getLooser() === "") {
            $this->flashBag->add('error',"Vous devez renseigner l'équipe vaincue.");
            return $this->router->generate('meeting_show', ['id' => $game->getMeeting()->getId()]);
        }
    }
    public function validateWinnerScore(Game $game)
    {
        if ($game->getWinnerScore() === null || $game->getWinnerScore() === "") {
            $this->flashBag->add('error',"Vous devez renseigner le score du vainqueur.");
            return $this->router->generate('meeting_show', ['id' => $game->getMeeting()->getId()]);
        }
    }
    public function validateLooserScore(Game $game)
    {
        if ($game->getLooserScore() === null || $game->getLooserScore() === "") {
            $this->flashBag->add('error',"Vous devez renseigner le score de l'équipe vaincue.");
            return $this->router->generate('meeting_show', ['id' => $game->getMeeting()->getId()]);
        }
    }
}
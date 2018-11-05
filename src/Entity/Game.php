<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @ApiResource()
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $opponent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $winner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $looser;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     */
    private $winner_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank()
     */
    private $looser_score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="games")
     */
    private $team;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appointment_location;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $appointment_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Meeting", inversedBy="games", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $meeting;

    /**
     * @ORM\Column(type="boolean")
     */
    private $canceled;

    public function __construct()
    {
        $this->canceled = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOpponent(): ?string
    {
        return $this->opponent;
    }

    public function setOpponent(string $opponent): self
    {
        $this->opponent = $opponent;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(?string $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getLooser(): ?string
    {
        return $this->looser;
    }

    public function setLooser(?string $looser): self
    {
        $this->looser = $looser;

        return $this;
    }

    public function getWinnerScore(): ?int
    {
        return $this->winner_score;
    }

    public function setWinnerScore(?int $winner_score): self
    {
        $this->winner_score = $winner_score;

        return $this;
    }

    public function getLooserScore(): ?int
    {
        return $this->looser_score;
    }

    public function setLooserScore(?int $looser_score): self
    {
        $this->looser_score = $looser_score;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getAppointmentLocation(): ?string
    {
        return $this->appointment_location;
    }

    public function setAppointmentLocation(string $appointment_location): self
    {
        $this->appointment_location = $appointment_location;

        return $this;
    }

    public function getAppointmentDate(): ?\DateTimeInterface
    {
        return $this->appointment_date;
    }

    public function setAppointmentDate(\DateTimeInterface $appointment_date): self
    {
        $this->appointment_date = $appointment_date;

        return $this;
    }

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function setMeeting(?Meeting $meeting): self
    {
        $this->meeting = $meeting;

        return $this;
    }

    public function getCanceled(): ?bool
    {
        return $this->canceled;
    }

    public function setCanceled(bool $canceled): self
    {
        $this->canceled = $canceled;

        return $this;
    }
}

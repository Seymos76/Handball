<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ApiResource()
 * @ApiFilter(DateFilter::class, properties={"meeting_date": DateFilter::EXCLUDE_NULL})
 * @ORM\Entity(repositoryClass="App\Repository\MeetingRepository")
 */
class Meeting
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
    private $meeting_date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="meeting", orphanRemoval=true, cascade={"persist","remove"})
     */
    private $games;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validated;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->validated = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeetingDate(): ?string
    {
        return $this->meeting_date;
    }

    public function setMeetingDate(string $meeting_date): self
    {
        $this->meeting_date = $meeting_date;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setMeeting($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getMeeting() === $this) {
                $game->setMeeting(null);
            }
        }

        return $this;
    }

    public function getValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }
}

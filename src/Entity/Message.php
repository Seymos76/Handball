<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     */
    private $date_sent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="parent", cascade={"persist","remove"})
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="answers")
     */
    private $parent;

    public function __construct()
    {
        $this->date_sent = new \DateTime('now');
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDateSent(): ?\DateTimeInterface
    {
        return $this->date_sent;
    }

    public function setDateSent(\DateTimeInterface $date_sent): self
    {
        $this->date_sent = $date_sent;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Message $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setParent($this);
        }

        return $this;
    }

    public function removeAnswer(Message $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getParent() === $this) {
                $answer->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Message
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Message $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }
}

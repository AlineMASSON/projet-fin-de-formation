<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TrainingRepository::class)
 */
class Training
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"app_api_trainings_triathletes_collection","app_api_trainings_get_item"})
     */
    private $id;
    
    /**
     * @Groups({"app_api_trainings_triathletes_collection","app_api_trainings_get_item"})
     * @ORM\Column(type="boolean")
     */
    private $isValidated;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"app_api_trainings_triathletes_collection","app_api_trainings_get_item"})
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"app_api_trainings_get_item"})
     */
    private $duration;

    
    /**
     * @ORM\Column(type="date")
     * @Groups({"app_api_trainings_triathletes_collection","app_api_trainings_get_item"})
     */
    private $date;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"app_api_trainings_triathletes_collection","app_api_trainings_get_item"})
     */
    private $sport;
    
    /**
     * @ORM\Column(type="boolean")
     * @Groups({"app_api_trainings_get_item"})
     */
    private $isPpg;
    
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"app_api_trainings_get_item"})
     */
    private $type;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"app_api_trainings_get_item"})
     */
    private $tag;
    
    /**
     * @ORM\Column(type="text")
     * @Groups({"app_api_trainings_get_item"})
     */
    private $description;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"app_api_trainings_get_item"})
     */
    private $feeling;
    
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trainings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"app_api_trainings_get_item"})
     */
    private $user;
    
    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="training", orphanRemoval=true)
     * @Groups({"app_api_trainings_get_item"})
     */
    private $reviews;

    /**
     * @ORM\ManyToOne(targetEntity=Triathlete::class, inversedBy="trainings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"app_api_trainings_triathletes_collection"})
     */
    private $triathlete;
    
    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->isValidated = false;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): self
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
    
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate()
    {
        $date = $this->date;
        return date_format($date, 'd-m-Y');
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSport(): ?string
    {
        return $this->sport;
    }

    public function setSport(string $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function isIsPpg(): ?bool
    {
        return $this->isPpg;
    }

    public function setIsPpg(bool $isPpg): self
    {
        $this->isPpg = $isPpg;

        return $this;
    }

    public function getFeeling(): ?string
    {
        return $this->feeling;
    }

    public function setFeeling(?string $feeling): self
    {
        $this->feeling = $feeling;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }


    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setTraining($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
    
            if ($review->getTraining() === $this) {
                $review->setTraining(null);
            }
        }

        return $this;
    }

    public function getTriathlete(): ?Triathlete
    {
        return $this->triathlete;
    }

    public function setTriathlete(?Triathlete $triathlete): self
    {
        $this->triathlete = $triathlete;

        return $this;
    }
}

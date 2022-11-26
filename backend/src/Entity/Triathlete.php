<?php

namespace App\Entity;

use App\Repository\TriathleteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TriathleteRepository::class)
 */
class Triathlete
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"app_api_get_triathletes_by_coach","app_api_triathletes_get_item","app_api_coachs_get_item"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(max=1200)
     * @Groups({"app_api_get_triathletes_by_coach","app_api_triathletes_get_item"})
     */
    private $palmares;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"app_api_get_triathletes_by_coach","app_api_triathletes_get_item"})
     */
    private $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"app_api_get_triathletes_by_coach","app_api_triathletes_get_item"})
     */
    private $size;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"app_api_get_triathletes_by_coach","app_api_trainings_triathletes_collection","app_api_triathletes_get_item","app_api_coachs_get_item"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Collaboration::class, mappedBy="triathlete", orphanRemoval=true)
     * @Groups({"app_api_triathletes_get_item"})
     */
    private $collaborations;

    /**
     * @ORM\OneToMany(targetEntity=Training::class, mappedBy="triathlete", orphanRemoval=true)
     */
    private $trainings;

    public function __construct()
    {
        $this->collaborations = new ArrayCollection();
        $this->trainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPalmares(): ?string
    {
        return $this->palmares;
    }

    public function setPalmares(?string $palmares): self
    {
        $this->palmares = $palmares;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Collaboration>
     */
    public function getCollaborations(): Collection
    {
        return $this->collaborations;
    }

    public function addCollaboration(Collaboration $collaboration): self
    {
        if (!$this->collaborations->contains($collaboration)) {
            $this->collaborations[] = $collaboration;
            $collaboration->setTriathlete($this);
        }

        return $this;
    }

    public function removeCollaboration(Collaboration $collaboration): self
    {
        if ($this->collaborations->removeElement($collaboration)) {
        
            if ($collaboration->getTriathlete() === $this) {
                $collaboration->setTriathlete(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->setTriathlete($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->removeElement($training)) {
       
            if ($training->getTriathlete() === $this) {
                $training->setTriathlete(null);
            }
        }

        return $this;
    }
}

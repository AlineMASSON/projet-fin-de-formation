<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CoachRepository::class)
 */
class Coach
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"app_api_coachs_get_collection","app_api_get_triathletes_by_coach","app_api_triathletes_get_item","app_api_coachs_get_item"})
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"app_api_coachs_get_collection","app_api_triathletes_get_item","app_api_coachs_get_item"})
     */
    private $swim;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"app_api_coachs_get_collection","app_api_triathletes_get_item","app_api_coachs_get_item"})
     */
    private $bike;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"app_api_coachs_get_collection","app_api_triathletes_get_item","app_api_coachs_get_item"})
     * 
     */
    private $run;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"app_api_coachs_get_item"})
     */
    private $experience;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"app_api_coachs_get_item"})
     */
    private $isAvailable;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"app_api_coachs_get_collection","app_api_triathletes_get_item","app_api_coachs_get_item"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Collaboration::class, mappedBy="coach", orphanRemoval=true)
     * @Groups({"app_api_get_triathletes_by_coach","app_api_coachs_get_item"})
     */
    private $collaborations;

    public function __construct()
    {
        $this->collaborations = new ArrayCollection();
        $this->isAvailable = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSwim(): ?bool
    {
        return $this->swim;
    }

    public function setSwim(bool $swim): self
    {
        $this->swim = $swim;

        return $this;
    }

    public function isBike(): ?bool
    {
        return $this->bike;
    }

    public function setBike(bool $bike): self
    {
        $this->bike = $bike;

        return $this;
    }

    public function isRun(): ?bool
    {
        return $this->run;
    }

    public function setRun(bool $run): self
    {
        $this->run = $run;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

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
            $collaboration->setCoach($this);
        }

        return $this;
    }

    public function removeCollaboration(Collaboration $collaboration): self
    {
        if ($this->collaborations->removeElement($collaboration)) {
            // set the owning side to null (unless already changed)
            if ($collaboration->getCoach() === $this) {
                $collaboration->setCoach(null);
            }
        }

        return $this;
    }
}

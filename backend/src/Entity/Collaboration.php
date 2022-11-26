<?php

namespace App\Entity;

use App\Repository\CollaborationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CollaborationRepository::class)
 */
class Collaboration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"app_api_get_triathletes_by_coach","app_api_triathletes_get_item","app_api_coachs_get_item"})
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="collaborations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"app_api_triathletes_get_item"})
     */
    private $coach;

    /**
     * @ORM\ManyToOne(targetEntity=Triathlete::class, inversedBy="collaborations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"app_api_get_triathletes_by_coach","app_api_coachs_get_item"})
     */
    private $triathlete;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"app_api_coachs_get_item"})
     */
    private $approved;

    public function __construct()
    {
        $this->approved = false;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCoach(): ?coach
    {
        return $this->coach;
    }

    public function setCoach(?coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getTriathlete(): ?triathlete
    {
        return $this->triathlete;
    }

    public function setTriathlete(?triathlete $triathlete): self
    {
        $this->triathlete = $triathlete;

        return $this;
    }

    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }
}

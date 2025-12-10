<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[ApiResource]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prénom = null;

    #[ORM\Column(length: 255)]
    private ?string $formation = null;

    #[ORM\ManyToOne(inversedBy: 'etudiants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tuteur $tuteur = null;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'edudiant')]
    private Collection $visites;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'etdudiant')]
    private Collection $no;

    public function __construct()
    {
        $this->visites = new ArrayCollection();
        $this->no = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrénom(): ?string
    {
        return $this->prénom;
    }

    public function setPrénom(string $prénom): static
    {
        $this->prénom = $prénom;

        return $this;
    }

    public function getFormation(): ?string
    {
        return $this->formation;
    }

    public function setFormation(string $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getTuteur(): ?Tuteur
    {
        return $this->tuteur;
    }

    public function setTuteur(?Tuteur $tuteur): static
    {
        $this->tuteur = $tuteur;

        return $this;
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): static
    {
        if (!$this->visites->contains($visite)) {
            $this->visites->add($visite);
            $visite->setEdudiant($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getEdudiant() === $this) {
                $visite->setEdudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getNo(): Collection
    {
        return $this->no;
    }

    public function addNo(Visite $no): static
    {
        if (!$this->no->contains($no)) {
            $this->no->add($no);
            $no->setEtdudiant($this);
        }

        return $this;
    }

    public function removeNo(Visite $no): static
    {
        if ($this->no->removeElement($no)) {
            // set the owning side to null (unless already changed)
            if ($no->getEtdudiant() === $this) {
                $no->setEtdudiant(null);
            }
        }

        return $this;
    }
}

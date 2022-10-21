<?php

namespace App\Entity;

use App\Repository\DetailsDevisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailsDevisRepository::class)
 */
class DetailsDevis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $fin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreVehicules;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tarifHT;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kilometrage;

    /**
     * @ORM\ManyToOne(targetEntity=Devis::class, inversedBy="detailsDevis")
     */
    private $Devis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDebut(): ?\DateTimeImmutable
    {
        return $this->debut;
    }

    public function setDebut(?\DateTimeImmutable $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeImmutable
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeImmutable $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getNombreVehicules(): ?string
    {
        return $this->nombreVehicules;
    }

    public function setNombreVehicules(string $nombreVehicules): self
    {
        $this->nombreVehicules = $nombreVehicules;

        return $this;
    }

    public function getTarifHT(): ?string
    {
        return $this->tarifHT;
    }

    public function setTarifHT(?string $tarifHT): self
    {
        $this->tarifHT = $tarifHT;

        return $this;
    }

    public function getKilometrage(): ?string
    {
        return $this->kilometrage;
    }

    public function setKilometrage(?string $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->Devis;
    }

    public function setDevis(?Devis $Devis): self
    {
        $this->Devis = $Devis;

        return $this;
    }
    
}

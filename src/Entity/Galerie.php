<?php

namespace App\Entity;

use App\Repository\GalerieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GalerieRepository::class)
 */
class Galerie
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
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $aller;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $retour;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contrat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAller(): ?bool
    {
        return $this->aller;
    }

    public function setAller(?bool $aller): self
    {
        $this->aller = $aller;

        return $this;
    }

    public function getRetour(): ?bool
    {
        return $this->retour;
    }

    public function setRetour(?bool $retour): self
    {
        $this->retour = $retour;

        return $this;
    }

    public function getContrat(): ?string
    {
        return $this->contrat;
    }

    public function setContrat(string $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }
}

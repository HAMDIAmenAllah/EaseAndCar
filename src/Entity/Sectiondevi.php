<?php

namespace App\Entity;

use App\Repository\SectiondeviRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectiondeviRepository::class)
 */
class Sectiondevi
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
    private $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $btn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlbtn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getBtn(): ?string
    {
        return $this->btn;
    }

    public function setBtn(?string $btn): self
    {
        $this->btn = $btn;

        return $this;
    }

    public function getUrlbtn(): ?string
    {
        return $this->urlbtn;
    }

    public function setUrlbtn(?string $urlbtn): self
    {
        $this->urlbtn = $urlbtn;

        return $this;
    }
}

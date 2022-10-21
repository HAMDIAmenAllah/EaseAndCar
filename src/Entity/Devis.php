<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 */
class Devis
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
    private $typeEntreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomEntreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroTel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseSiege;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $departementDepart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $debutLocation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finLocation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeVehicule;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeLocation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombrePlaces;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $besoinChauffeur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut = "en attente";

    /**
     * @ORM\OneToMany(targetEntity=Notes::class, mappedBy="relationDevis", cascade={"remove"}))
     */
    private $note;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TVA;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conditionReglement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numDevis;

    /**
     * @ORM\ManyToOne(targetEntity=Easeandcar::class, inversedBy="devis")
     */
    private $EaseCar;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="devis")
     */
    private $Client;

    /**
     * @ORM\OneToMany(targetEntity=DetailsDevis::class, mappedBy="Devis", cascade={"remove"}))
     */
    private $detailsDevis;

    /**
     * @ORM\Column(type="boolean")
     */
    private $consentement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delaiDevis;


    public function __construct()
    {
        $this->note = new ArrayCollection();
        $this->detailsDevis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeEntreprise(): ?string
    {
        return $this->typeEntreprise;
    }

    public function setTypeEntreprise(?string $typeEntreprise): self
    {
        $this->typeEntreprise = $typeEntreprise;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(?string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getAdresseEmail(): ?string
    {
        return $this->adresseEmail;
    }

    public function setAdresseEmail(?string $adresseEmail): self
    {
        $this->adresseEmail = $adresseEmail;

        return $this;
    }

    public function getNumeroTel(): ?string
    {
        return $this->numeroTel;
    }

    public function setNumeroTel(?string $numeroTel): self
    {
        $this->numeroTel = $numeroTel;

        return $this;
    }

    public function getAdresseSiege(): ?string
    {
        return $this->adresseSiege;
    }

    public function setAdresseSiege(?string $adresseSiege): self
    {
        $this->adresseSiege = $adresseSiege;

        return $this;
    }

    public function getDepartementDepart(): ?string
    {
        return $this->departementDepart;
    }

    public function setDepartementDepart(?string $departementDepart): self
    {
        $this->departementDepart = $departementDepart;

        return $this;
    }

    public function getDebutLocation(): ?\DateTimeInterface
    {
        return $this->debutLocation;
    }

    public function setDebutLocation(?\DateTimeInterface $debutLocation): self
    {
        $this->debutLocation = $debutLocation;

        return $this;
    }

    public function getFinLocation(): ?\DateTimeInterface
    {
        return $this->finLocation;
    }

    public function setFinLocation(?\DateTimeInterface $finLocation): self
    {
        $this->finLocation = $finLocation;

        return $this;
    }

    public function getTypeVehicule(): ?string
    {
        return $this->typeVehicule;
    }

    public function setTypeVehicule(?string $typeVehicule): self
    {
        $this->typeVehicule = $typeVehicule;

        return $this;
    }

    public function getTypeLocation(): ?string
    {
        return $this->typeLocation;
    }

    public function setTypeLocation(?string $typeLocation): self
    {
        $this->typeLocation = $typeLocation;

        return $this;
    }

    public function getNombrePlaces(): ?int
    {
        return $this->nombrePlaces;
    }

    public function setNombrePlaces(int $nombrePlaces): self
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    public function getBesoinChauffeur(): ?string
    {
        return $this->besoinChauffeur;
    }

    public function setBesoinChauffeur(?string $besoinChauffeur): self
    {
        $this->besoinChauffeur = $besoinChauffeur;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Notes[]
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(Notes $note): self
    {
        if (!$this->note->contains($note)) {
            $this->note[] = $note;
            $note->setRelation($this);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getRelation() === $this) {
                $note->setRelation(null);
            }
        }

        return $this;
    }
    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTVA(): ?string
    {
        return $this->TVA;
    }

    public function setTVA(?string $TVA): self
    {
        $this->TVA = $TVA;

        return $this;
    }

    public function getConditionReglement(): ?string
    {
        return $this->conditionReglement;
    }

    public function setConditionReglement(?string $conditionReglement): self
    {
        $this->conditionReglement = $conditionReglement;

        return $this;
    }

    public function getNumDevis(): ?string
    {
        return $this->numDevis;
    }

    public function setNumDevis(?string $numDevis): self
    {
        $this->numDevis = $numDevis;

        return $this;
    }

    public function getEaseCar(): ?Easeandcar
    {
        return $this->EaseCar;
    }

    public function setEaseCar(?Easeandcar $EaseCar): self
    {
        $this->EaseCar = $EaseCar;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    /**
     * @return Collection|DetailsDevis[]
     */
    public function getDetailsDevis(): Collection
    {
        return $this->detailsDevis;
    }

    public function addDetailsDevi(DetailsDevis $detailsDevi): self
    {
        if (!$this->detailsDevis->contains($detailsDevi)) {
            $this->detailsDevis[] = $detailsDevi;
            $detailsDevi->setDevis($this);
        }

        return $this;
    }

    public function removeDetailsDevi(DetailsDevis $detailsDevi): self
    {
        if ($this->detailsDevis->removeElement($detailsDevi)) {
            // set the owning side to null (unless already changed)
            if ($detailsDevi->getDevis() === $this) {
                $detailsDevi->setDevis(null);
            }
        }

        return $this;
    }

    public function getConsentement(): ?bool
    {
        return $this->consentement;
    }

    public function setConsentement(bool $consentement): self
    {
        $this->consentement = $consentement;

        return $this;
    }

    public function getDelaiDevis(): ?string
    {
        return $this->delaiDevis;
    }

    public function setDelaiDevis(?string $delaiDevis): self
    {
        $this->delaiDevis = $delaiDevis;

        return $this;
    }

}

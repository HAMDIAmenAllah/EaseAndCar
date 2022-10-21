<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContratRepository::class)
 */
class Contrat
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
    private $numContrat;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raisonSociale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephoneClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixHt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixTtc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $debut;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $fin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numTVA;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TVA;

    /**
     * @ORM\OneToMany(targetEntity=Notes::class, mappedBy="contrat", cascade={"remove"}))
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $formeJuridique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RCS;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $societeClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carburant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emplacement;

    public function __construct()
    {
        $this->note = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumContrat(): ?string
    {
        return $this->numContrat;
    }

    public function setNumContrat(?string $numContrat): self
    {
        $this->numContrat = $numContrat;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(?string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
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

    public function getAdresseClient(): ?string
    {
        return $this->adresseClient;
    }

    public function setAdresseClient(?string $adresseClient): self
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    public function getTelephoneClient(): ?string
    {
        return $this->telephoneClient;
    }

    public function setTelephoneClient(?string $telephoneClient): self
    {
        $this->telephoneClient = $telephoneClient;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPrixHt(): ?string
    {
        return $this->prixHt;
    }

    public function setPrixHt(?string $prixHt): self
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    public function getPrixTtc(): ?string
    {
        return $this->prixTtc;
    }

    public function setPrixTtc(?string $prixTtc): self
    {
        $this->prixTtc = $prixTtc;

        return $this;
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

    public function setNombreVehicules(?string $nombreVehicules): self
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

    public function getNumTVA(): ?string
    {
        return $this->numTVA;
    }

    public function setNumTVA(?string $numTVA): self
    {
        $this->numTVA = $numTVA;

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

    /**
     * @return Collection|notes[]
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(notes $note): self
    {
        if (!$this->note->contains($note)) {
            $this->note[] = $note;
            $note->setContrat($this);
        }

        return $this;
    }

    public function removeNote(notes $note): self
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getContrat() === $this) {
                $note->setContrat(null);
            }
        }

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getFormeJuridique(): ?string
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(?string $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getRCS(): ?string
    {
        return $this->RCS;
    }

    public function setRCS(?string $RCS): self
    {
        $this->RCS = $RCS;

        return $this;
    }

    public function getSocieteClient(): ?string
    {
        return $this->societeClient;
    }

    public function setSocieteClient(?string $societeClient): self
    {
        $this->societeClient = $societeClient;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(?string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(?string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

 
}

<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
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
    private $numFacture;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raisonSociale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephoneClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="float")
     */
    private $prixHt;

    /**
     * @ORM\Column(type="float")
     */
    private $prixTtc;

    /**
     * @ORM\OneToMany(targetEntity=Notes::class, mappedBy="facture", cascade={"remove"}))
     */
    private $note;

    /**
     * @ORM\OneToMany(targetEntity=DetailsFacture::class, mappedBy="facture", cascade={"remove"}))
     */
    private $detailsFactures;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numTVA;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TVA;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $formeJuridique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conditionReglement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delaiFacture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delaiPaiement;

    public function __construct()
    {
        $this->note = new ArrayCollection();
        $this->detailsFactures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFacture(): ?string
    {
        return $this->numFacture;
    }

    public function setNumFacture(string $numFacture): self
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresseClient;
    }

    public function setAdresseClient(string $adresseClient): self
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    public function getTelephoneClient(): ?string
    {
        return $this->telephoneClient;
    }

    public function setTelephoneClient(string $telephoneClient): self
    {
        $this->telephoneClient = $telephoneClient;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPrixHt(): ?float
    {
        return $this->prixHt;
    }

    public function setPrixHt(float $prixHt): self
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    public function getPrixTtc(): ?float
    {
        return $this->prixTtc;
    }

    public function setPrixTtc(float $prixTtc): self
    {
        $this->prixTtc = $prixTtc;

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
            $note->setFacture($this);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getFacture() === $this) {
                $note->setFacture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DetailsFacture[]
     */
    public function getDetailsFactures(): Collection
    {
        return $this->detailsFactures;
    }

    public function addDetailsFacture(DetailsFacture $detailsFacture): self
    {
        if (!$this->detailsFactures->contains($detailsFacture)) {
            $this->detailsFactures[] = $detailsFacture;
            $detailsFacture->setFacture($this);
        }

        return $this;
    }

    public function removeDetailsFacture(DetailsFacture $detailsFacture): self
    {
        if ($this->detailsFactures->removeElement($detailsFacture)) {
            // set the owning side to null (unless already changed)
            if ($detailsFacture->getFacture() === $this) {
                $detailsFacture->setFacture(null);
            }
        }

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

    public function getFormeJuridique(): ?string
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(?string $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

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

    public function getDelaiFacture(): ?string
    {
        return $this->delaiFacture;
    }

    public function setDelaiFacture(string $delaiFacture): self
    {
        $this->delai = $delaiFacture;

        return $this;
    }

    public function getDelaiPaiement(): ?string
    {
        return $this->delaiPaiement;
    }

    public function setDelaiPaiement(?string $delaiPaiement): self
    {
        $this->delaiPaiement = $delaiPaiement;

        return $this;
    }
}

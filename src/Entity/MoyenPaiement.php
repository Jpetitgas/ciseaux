<?php

namespace App\Entity;

use App\Repository\MoyenPaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoyenPaiementRepository::class)
 */
class MoyenPaiement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeDePaiement;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="typeDePaiement")
     */
    private $factures;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeDePaiement(): ?string
    {
        return $this->typeDePaiement;
    }

    public function setTypeDePaiement(string $typeDePaiement): self
    {
        $this->typeDePaiement = $typeDePaiement;

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setTypeDePaiement($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getTypeDePaiement() === $this) {
                $facture->setTypeDePaiement(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        $typepaiement =$this->typeDePaiement;
        return $typepaiement;
    }
}

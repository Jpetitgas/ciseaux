<?php

namespace App\Entity;

use App\Repository\DetailFactureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailFactureRepository::class)
 */
class DetailFacture
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
    private $designation;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="detail")
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity=Prestation::class, inversedBy="detailFactures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typePrestation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getTypePrestation(): ?Prestation
    {
        return $this->typePrestation;
    }

    public function setTypePrestation(?Prestation $typePrestation): self
    {
        $this->typePrestation = $typePrestation;

        return $this;
    }
    
   
}

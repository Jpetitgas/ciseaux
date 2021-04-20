<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrestationRepository::class)
 */
class Prestation
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
    private $typeDePrestation;

    /**
     * @ORM\OneToMany(targetEntity=DetailFacture::class, mappedBy="typePrestation")
     */
    private $detailFactures;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $colors;

    public function __construct()
    {
        $this->detailFactures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeDePrestation(): ?string
    {
        return $this->typeDePrestation;
    }

    public function setTypeDePrestation(string $typeDePrestation): self
    {
        $this->typeDePrestation = $typeDePrestation;

        return $this;
    }

    /**
     * @return Collection|DetailFacture[]
     */
    public function getDetailFactures(): Collection
    {
        return $this->detailFactures;
    }

    public function addDetailFacture(DetailFacture $detailFacture): self
    {
        if (!$this->detailFactures->contains($detailFacture)) {
            $this->detailFactures[] = $detailFacture;
            $detailFacture->setTypePrestation($this);
        }

        return $this;
    }

    public function removeDetailFacture(DetailFacture $detailFacture): self
    {
        if ($this->detailFactures->removeElement($detailFacture)) {
            // set the owning side to null (unless already changed)
            if ($detailFacture->getTypePrestation() === $this) {
                $detailFacture->setTypePrestation(null);
            }
        }

        return $this;
    }
     public function __toString()
    {
        $prestation =$this->typeDePrestation;
        return $prestation;
    }

     public function getColors(): ?string
     {
         return $this->colors;
     }

     public function setColors(string $colors): self
     {
         $this->colors = $colors;

         return $this;
     }
}

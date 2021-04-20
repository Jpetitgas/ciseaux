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
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=DetailFacture::class, mappedBy="facture")
     */
    private $detail;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="factures")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=MoyenPaiement::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeDePaiement;

    public function __construct()
    {
        $this->detail = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|DetailFacture[]
     */
    public function getDetail(): Collection
    {
        return $this->detail;
    }

    public function addDetail(DetailFacture $detail): self
    {
        if (!$this->detail->contains($detail)) {
            $this->detail[] = $detail;
            $detail->setFacture($this);
        }

        return $this;
    }

    public function removeDetail(DetailFacture $detail): self
    {
        if ($this->detail->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getFacture() === $this) {
                $detail->setFacture(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
    public function __toString()
    {
        $detail="Ref °".$this->id;
        return $detail;
    }

    public function getTypeDePaiement(): ?MoyenPaiement
    {
        return $this->typeDePaiement;
    }

    public function setTypeDePaiement(?MoyenPaiement $typeDePaiement): self
    {
        $this->typeDePaiement = $typeDePaiement;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ApprovisionnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApprovisionnementRepository::class)]
class Approvisionnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\ManyToOne(inversedBy: 'approvisionnements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    /**
     * @var Collection<int, LigneAppro>
     */
    #[ORM\OneToMany(targetEntity: LigneAppro::class, mappedBy: 'approvisionnement')]
    private Collection $ligneAppros;

    public function __construct()
    {
        $this->ligneAppros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * @return Collection<int, LigneAppro>
     */
    public function getLigneAppros(): Collection
    {
        return $this->ligneAppros;
    }

    public function addLigneAppro(LigneAppro $ligneAppro): static
    {
        if (!$this->ligneAppros->contains($ligneAppro)) {
            $this->ligneAppros->add($ligneAppro);
            $ligneAppro->setApprovisionnement($this);
        }

        return $this;
    }

    public function removeLigneAppro(LigneAppro $ligneAppro): static
    {
        if ($this->ligneAppros->removeElement($ligneAppro)) {
            // set the owning side to null (unless already changed)
            if ($ligneAppro->getApprovisionnement() === $this) {
                $ligneAppro->setApprovisionnement(null);
            }
        }

        return $this;
    }
}

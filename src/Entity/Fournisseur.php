<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Approvisionnement>
     */
    #[ORM\OneToMany(targetEntity: Approvisionnement::class, mappedBy: 'fournisseur')]
    private Collection $approvisionnements;

    public function __construct()
    {
        $this->approvisionnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Approvisionnement>
     */
    public function getApprovisionnements(): Collection
    {
        return $this->approvisionnements;
    }

    public function addApprovisionnement(Approvisionnement $approvisionnement): static
    {
        if (!$this->approvisionnements->contains($approvisionnement)) {
            $this->approvisionnements->add($approvisionnement);
            $approvisionnement->setFournisseur($this);
        }

        return $this;
    }

    public function removeApprovisionnement(Approvisionnement $approvisionnement): static
    {
        if ($this->approvisionnements->removeElement($approvisionnement)) {
            // set the owning side to null (unless already changed)
            if ($approvisionnement->getFournisseur() === $this) {
                $approvisionnement->setFournisseur(null);
            }
        }

        return $this;
    }
}

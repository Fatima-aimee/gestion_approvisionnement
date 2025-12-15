<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $prix = null;

    /**
     * @var Collection<int, LigneAppro>
     */
    #[ORM\OneToMany(targetEntity: LigneAppro::class, mappedBy: 'article')]
    private Collection $ligneAppros;

    public function __construct()
    {
        $this->ligneAppros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

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
            $ligneAppro->setArticle($this);
        }

        return $this;
    }

    public function removeLigneAppro(LigneAppro $ligneAppro): static
    {
        if ($this->ligneAppros->removeElement($ligneAppro)) {
            // set the owning side to null (unless already changed)
            if ($ligneAppro->getArticle() === $this) {
                $ligneAppro->setArticle(null);
            }
        }

        return $this;
    }
}

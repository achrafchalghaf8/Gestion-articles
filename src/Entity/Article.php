<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\ArticleRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[UniqueEntity('reference')]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^[A-Z]{4}-[0-9]{3}$/')]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $libelle = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Positive]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}

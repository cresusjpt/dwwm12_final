<?php

namespace App\Entity;

use App\Repository\CLientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CLientRepository::class)
 */
class CLient
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostal;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="cLient")
     */
    private $passer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cLients")
     */
    private $etrede;

    public function __construct()
    {
        $this->passer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

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

    /**
     * @return Collection|Commande[]
     */
    public function getPasser(): Collection
    {
        return $this->passer;
    }

    public function addPasser(Commande $passer): self
    {
        if (!$this->passer->contains($passer)) {
            $this->passer[] = $passer;
            $passer->setCLient($this);
        }

        return $this;
    }

    public function removePasser(Commande $passer): self
    {
        if ($this->passer->removeElement($passer)) {
            // set the owning side to null (unless already changed)
            if ($passer->getCLient() === $this) {
                $passer->setCLient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getEtrede(): ?User
    {
        return $this->etrede;
    }

    public function setEtrede(?User $etrede): self
    {
        $this->etrede = $etrede;

        return $this;
    }
}

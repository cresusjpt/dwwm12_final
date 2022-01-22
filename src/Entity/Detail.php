<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailRepository::class)
 */
class Detail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $detail_produit;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $detail_commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getDetailProduit(): ?Produit
    {
        return $this->detail_produit;
    }

    public function setDetailProduit(?Produit $detail_produit): self
    {
        $this->detail_produit = $detail_produit;
        return $this;
    }

    public function getDetailCommande(): ?Commande
    {
        return $this->detail_commande;
    }

    public function setDetailCommande(?Commande $detail_commande): self
    {
        $this->detail_commande = $detail_commande;

        return $this;
    }
}

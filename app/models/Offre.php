<?php
namespace  App\models;
use App\models\Commande;
use App\models\Livreur;
use App\models\Vehicule;
use DateTime;

class Offre
{
    private ?int $id;
    private  float $prix;
    private Commande $commande;
    private Livreur $livreur;
    private DateTime $dureEstime;
    private Vehicule $typeVehicule;


    public function  __construct(int $id, float $prix, Commande $commande, Livreur $livreur, DateTime $dureEstime, Vehicule $typeVehicule )
    {
        $this->id = $id;
        $this->prix = $prix;
        $this->commande = $commande;
        $this->livreur  = $livreur;
        $this->dureEstime = $dureEstime;
        $this->typeVehicule = $typeVehicule;
    }

    /* getters */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function getCommande(): \App\models\Commande
    {
        return $this->commande;
    }

    public function getDureEstime(): DateTime
    {
        return $this->dureEstime;
    }

    public function getLivreur(): \App\models\Livreur
    {
        return $this->livreur;
    }

    public function getTypeVehicule(): Vehicule
    {
        return $this->typeVehicule;
    }

    /* setters */

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    public function setCommande(\App\models\Commande $commande): void
    {
        $this->commande = $commande;
    }

    public function setDureEstime(DateTime $dureEstime): void
    {
        $this->dureEstime = $dureEstime;
    }

    public function setLivreur(\App\models\Livreur $livreur): void
    {
        $this->livreur = $livreur;
    }

    public function setTypeVehicule(Vehicule $typeVehicule): void
    {
        $this->typeVehicule = $typeVehicule;
    }
}
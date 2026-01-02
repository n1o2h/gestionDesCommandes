<?php
namespace App\models;

use App\models\Client;
use App\models\Offre;

class Commande
{
    private ?int $id;
    private string $description;
    private string $etat;
    private Client $client;
    private Offre|array $listOffres = [];

    public function __construct(int $id, string $description, string $etat, Client $client, Offre $listOffres){
        $this->id = $id;
        $this->description = $description;
        $this-> client = $client;
        $this->etat = $etat;
        $this->listOffres = $listOffres;
    }

    /* getter */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getEtat(): string
    {
        return $this->etat;
    }

    public function getClient(): \App\models\Client
    {
        return $this->client;
    }

    public function getListOffres(): array|\App\models\Offre
    {
        return $this->listOffres;
    }

    /* setters */

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setClient(\App\models\Client $client): void
    {
        $this->client = $client;
    }

    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }

    public function setListOffres(array|\App\models\Offre $listOffres): void
    {
        $this->listOffres = $listOffres;
    }


}
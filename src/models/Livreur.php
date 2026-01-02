<?php
namespace App\models;

use App\models\Utilisateur;
use App\models\Offre;

class Livreur extends Utilisateur
{
    private float $noteMoyenne;
    private Offre|array $offresEnvoyes = [];

    public function __construct(int $id, string $nomComplet, string $email, string $password, string $role, bool $active, Notification $listNotification, float $noteMoyenne, Offre $offresEnvoyes)
    {
        parent::__construct($id, $nomComplet, $email, $password, $role, $active, $listNotification);
        $this->noteMoyenne = $noteMoyenne;
        $this->offresEnvoyes = $offresEnvoyes;
    }

    /* getters */
    public function getNoteMoyenne(): float
    {
        return $this->noteMoyenne;
    }

    public function getOffresEnvoyes(): Offre|array
    {
        return $this->offresEnvoyes;
    }

    /* setters */
    public function setNoteMoyenne(float $noteMoyenne): void
    {
        $this->noteMoyenne = $noteMoyenne;
    }

    public function setOffresEnvoyes(Offre|array $offresEnvoyes): void
    {
        $this->offresEnvoyes = $offresEnvoyes;
    }

}
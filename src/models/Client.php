<?php
namespace App\models;
use App\models\Commande;
use App\models\Utilisateur;

class Client extends Utilisateur
{
    private Commande|array $historiqueCommandes = [];

    public function __construct(int $id, string $nomComplet, string $email, string $password, string $role, bool $active, Notification $listNotification,  Commande $historiqueCommandes)
    {
        parent::__construct($id, $nomComplet, $email, $password, $role, $active, $listNotification);
        $this->historiqueCommandes = $historiqueCommandes;
    }


    public function getHistoriqueCommandes(): Commande
    {
        return $this->historiqueCommandes;
    }

    public function setHistoriqueCommandes(Commande $historiqueCommandes): void
    {
        $this->historiqueCommandes = $historiqueCommandes;
    }

}
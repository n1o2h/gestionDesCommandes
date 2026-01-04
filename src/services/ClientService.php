<?php
namespace App\services;

use App\repositories\utilisateurRepository;
use App\repositories\CommandeRepository;
use App\repositories\OffreRepository;
use App\repositories\NotificationRepository;

class ClientService
{
    private utilisateurRepository $repo;

    public function __construct()
    {
        $this->repo = new utilisateurRepository();
    }

    public function createCommande(int $clientId, string $description) : int
    {

    }

    public function updateCommande(int $commandeId, array $data) : bool
    {

    }

    public function deleteCommande(int $commandeId) : bool
    {

    }

    public function getMyCommandes(int $clientId) : array
    {

    }

    public function getCommandeDetails(int $commandeId) : array | null
    {

    }

    public function accepteOffre( int $offreId, int $clientId) : bool
    {

    }
    public function getNotifications(int $clientId) : array
    {

    }
    public function validateDelivery(int $commandeId) : bool
    {

    }

    public function setNoteMoyenneOfLivreur(float $noteMoyenne) : bool
    {

    }
}
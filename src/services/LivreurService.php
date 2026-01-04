<?php

namespace App\services;

use App\repositories\utilisateurRepository;
use DateTime;

class LivreurService
{
    private utilisateurRepository $repo;
    public function __construct()
    {
        $this->repo = new utilisateurRepository();
    }

    public function getAvailableCommande() : array
    {

    }

    public function getCommandeDetails(int $commandeId) : array | null
    {

    }

    public function getOffersForCommandes(int $commandeId) : array
    {

    }

    public function createOffer(int $livreurId, int $commandeId, float $prix, DateTime $dure, int $vehiculeId, array $options = []) : int
    {

    }

    public function getMyOffers(int $livreurId) : array
    {

    }

    public function updateCommandeState(int $commandeId, string $stat): bool
    {

    }

    public function getNotifications(int $livreurId) : array
    {

    }
    public function getNoteMoyenne(int $livreurId) : float
    {

    }
}
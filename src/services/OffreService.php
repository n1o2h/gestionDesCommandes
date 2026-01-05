<?php

namespace App\services;

use App\repositories\LivreurRepository;
use App\repositories\utilisateurRepository;
use DateTime;

class OffreService
{
    private OffreService $repo;
    public function __construct()
    {
        $this->repo = new OffreService();
    }

    public function create(int $livreurId, int $commandeId, float $prix, DateTime $dure, int $vehiculeId/*, array $options=[]*/) : int
    {
            return $this->create($livreurId, $commandeId, $prix, $dure, $vehiculeId);
    }

    public function getByCommande(int $commandeId) : array
    {
        validator::validateExistingCommande($commandeId);
        return $this->repo->getByCommande($commandeId);
    }

    public function getByLivreur(int $livreurId) : array
    {

    }

    public function accept(int $offreId) : bool
    {

    }

}
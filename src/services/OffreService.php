<?php

namespace App\services;

use App\repositories\utilisateurRepository;
use DateTime;

class OffreService
{
    private utilisateurRepository $repo;
    public function __construct()
    {
        $this->repo = new utilisateurRepository();
    }

    public function create(int $livreurId, int $commandeId, float $prix, DateTime $dure, int $vehiculeId, array $options=[]) : int
    {

    }

    public function getByCommande(int $commandeId) : array
    {

    }

    public function getByLivreur(int $livreurId) : array
    {

    }

    public function accept(int $offreId) : bool
    {

    }

}
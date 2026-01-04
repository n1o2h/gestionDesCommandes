<?php

namespace App\services;

use App\repositories\utilisateurRepository;
use DateTime;

class CommandeService
{
    private utilisateurRepository $repo;
    public function __construct()
    {
        $this->repo = new utilisateurRepository();
    }

    public function create(int $clientId, string $description) : int
    {

    }

    public function update(int $commandeId, array $data) : bool
    {

    }

    public function delete(int $commandId): bool
    {

    }

    public function changeState(int $commandeId, $newState) : bool
    {

    }

    public function getDetails(int $commandeId) : array | null
    {

    }

}
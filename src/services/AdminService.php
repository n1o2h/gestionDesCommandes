<?php

namespace App\services;

use App\config\DatabaseConnect;
use App\Exception\validationException;
use App\repositories\AdminRepository;
use App\repositories\utilisateurRepository;
use App\repositories\CommandeRepository;
use App\repositories\OffreRepository;

class AdminService
{
    private AdminRepository $adminRepo;
    private utilisateurRepository $userRepo;
    private CommandeRepository $commandeRepo;
    private OffreRepository $offreRepo;

    public function __construct()
    {
        $this->adminRepo    = new AdminRepository();
        $this->userRepo     = new utilisateurRepository();
        $this->commandeRepo = new CommandeRepository();
        $this->offreRepo    = new OffreRepository();
    }

    /* ================= USERS ================= */

    public function getAllUsers() : array
    {
        return $this->userRepo->findAll();
    }

    public function activeUser(int $userId) : bool
    {
        validator::validateExistingUser($userId, DatabaseConnect::getConnexion());
        return $this->userRepo->updateStatus($userId, true);
    }

    public function desactivateUser(int $userId) : bool
    {
        validator::validateExistingUser($userId, DatabaseConnect::getConnexion());
        return $this->userRepo->updateStatus($userId, false);
    }

    public function assignRole(int $userId, string $role) : bool
    {
        validator::validateExistingUser($userId, DatabaseConnect::getConnexion());

        $rolesAutorises = ['client', 'livreur', 'admin'];
        if(!in_array($role, $rolesAutorises)){
            throw new validationException("Rôle invalide");
        }

        return $this->userRepo->updateRole($userId, $role);
    }

    /* ================= STATS ================= */

    public function getStats() : array
    {
        return [
            'users'     => $this->userRepo->countAll(),
            'commandes' => $this->commandeRepo->countAll(),
            'offres'    => $this->offreRepo->countAll(),
            'livreurs'  => $this->userRepo->countByRole('livreur'),
            'clients'   => $this->userRepo->countByRole('client')
        ];
    }

    /* ================= ACTIVITÉ LIVREUR ================= */

    public function getUserActivity(int $livreurId) : array
    {
        validator::validateExistingLivreur($livreurId, DatabaseConnect::getConnexion());

        return [
            'commandes_livrees' => $this->commandeRepo->findByLivreurId($livreurId),
            'offres'            => $this->offreRepo->findByLivreurId($livreurId),
            'note_moyenne'      => $this->userRepo->getNoteMoyenne($livreurId)
        ];
    }
}

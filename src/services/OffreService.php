<?php

namespace App\services;

use App\config\DatabaseConnect;
use App\Exception\validationException;
use App\repositories\CommandeRepository;
use App\repositories\LivreurRepository;
use App\repositories\NotificationRepository;
use App\repositories\OffreRepository;
use App\repositories\utilisateurRepository;
use DateTime;

class OffreService
{
    private OffreRepository $offreRepo;
    private CommandeRepository $commandeRepo;
    private LivreurRepository $livreurRepo;
    private NotificationRepository $notifRepo;

    public function __construct()
    {
        $this->offreRepo = new OffreRepository();
        $this->commandeRepo = new CommandeRepository();
        $this->livreurRepo = new LivreurRepository();
        $this->notifRepo = new NotificationRepository();
    }

    public function createOffre(int $livreurId, int $commandeId, float $prix, DateTime $dure, int $vehiculeId/*, array $options=[]*/) : int
    {
        validator::validateExistingLivreur($livreurId, DatabaseConnect::getConnexion());
        validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        $commande = $this->commandeRepo->findById($commandeId);
        if($commande['etat'] !== "Crée" AND $commande['etat'] !== "En_attente"){
            throw new validationException("Accès refusé à cette commande");
        }
        $offre = $this->offreRepo->findByLivreurId($livreurId);
        if($offre){
            throw new validationException(" déjà une offre du même livreur");
        }

        validator::validateDateTime($dure);
        validator::validateExistingVehicule($vehiculeId, DatabaseConnect::getConnexion());
        $idOffre = $this->offreRepo->save($livreurId, $commandeId, $prix, $dure, $vehiculeId, 'En_attente');
        #$this->notifRepo->notifierClient
        return $idOffre;
    }

    public function getOffresByCommande(int $commandeId, string $role, ?int $livreurId = null) : array
    {
        validator::validateExistingCommande($commandeId);
        $offres = $this->offreRepo->findByCommandeId($commandeId);

        if($role === 'livreur' && $livreurId !== null){
           foreach ($offres as $offre){
               if($offre['livreur_id'] !== $livreurId){
                   $offre['prix'] = null;
               }
           }
        }
        return $offres;
    }

    public function getOffresByLivreur(int $livreurId) : array
    {
        validator::validateExistingLivreur($livreurId, DatabaseConnect::getConnexion());
        $mesOffres = $this->offreRepo->findByLivreurId($livreurId);
        return $mesOffres;
    }
}
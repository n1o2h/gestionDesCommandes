<?php

namespace App\services;

use App\config\DatabaseConnect;
use App\Exception\validationException;
use App\repositories\CommandeRepository;
use App\repositories\LivreurRepository;
use App\repositories\NotificationRepository;
use App\repositories\OffreRepository;
use App\repositories\utilisateurRepository;

use Cassandra\DefaultTable;
use DateTime;

class LivreurService
{
    private CommandeRepository $repo;
    private OffreRepository $offre;
    private NotificationRepository $notif;
    private LivreurRepository $livreurRepo;
    public function __construct()
    {
        $this->repo = new CommandeRepository();
        $this->offre = new OffreRepository();
        $this->notif = new NotificationRepository();
        $this->livreurRepo = new LivreurRepository();
    }

    public function getAvailableCommande() : array
    {
        return $this->repo->findByEtat(["Crée","En_attente"]);
    }

    public function getCommandeDetails(int $commandeId,  ?int $livreurId = null) : array | null
    {
        validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        $offres =  $this->repo->findById($commandeId);
        if ($livreurId !== null) {
            foreach ($offres as &$offre) {
                if ($offre['livreur_id'] !== $livreurId) {
                    $offre['prix'] = null;
                }
            }
        }
        return $offres;
    }

    public function getOffersForCommandes(int $commandeId) : array | null
    {
        validator::validateExistingCommande($commandeId);
        return $this->offre->findByCommandeId($commandeId);
    }

    public function createOffer(int $livreurId, int $commandeId, float $prix, string $dure, int $vehiculeId, array $options = []) : int
    {
        validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        validator::validateExistingLivreur($livreurId, DatabaseConnect::getConnexion());
        validator::validateExistingVehicule($vehiculeId, DatabaseConnect::getConnexion());
        $commande = $this->repo->findById($commandeId);
        if ($commande['etat'] !== "Crée" && $commande['etat'] !== "En_attente") {
            throw new validationException("Accès refusé à cette commande");
        }

        $offreExist = $this->offre->findByLivreurIdAndCommandeId($livreurId, $commandeId);
        if ($offreExist) {
            throw new validationException("Vous avez déjà une offre pour cette commande");
        }
        $date = new DateTime($dure);
        validator::validateDateTime($date, "Dure d'envoi");
        $offreId = $this->offre->save($prix, $date, $commandeId, $livreurId, $vehiculeId,  'En_attente');
        return $offreId;
    }

    public function getMyOffers(int $livreurId) : array | null
    {
        validator::validateExistingLivreur($livreurId, DatabaseConnect::getConnexion());
        return $this->offre->findByLivreurId($livreurId);
    }

    public function updateCommandeState(int $commandeId, string $etat, int $clientId) : bool
    {
        validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        $commande = $this->repo->findById($commandeId);

        if (!in_array($etat, ["En_cours", "Expédiée", "Terminee"])) {
            throw new validationException("État de commande invalide");
        }

        return $this->repo->updateEtat($etat, $commandeId, $clientId);
    }

    public function getNotifications(int $livreurId) : array
    {
        validator::validateExistingLivreur($livreurId, DatabaseConnect::getConnexion());
        return $this->notif->findByUtilisateurId($livreurId);
    }
    public function getNoteMoyenne(int $livreurId) : float
    {
        validator::validateExistingLivreur($livreurId, DatabaseConnect::getConnexion());
        return $this->livreurRepo->getNoteMoyenne($livreurId);
    }
}
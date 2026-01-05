<?php
namespace App\services;

use App\config\DatabaseConnect;
use App\Exception\validationException;
use App\repositories\ClientRepository;
use App\repositories\LivreurRepository;
use App\repositories\utilisateurRepository;
use App\repositories\CommandeRepository;
use App\repositories\OffreRepository;
use App\repositories\NotificationRepository;

class ClientService
{
    private CommandeRepository $repo;
    private NotificationRepository $notif;
    private OffreRepository $offre;
    private LivreurRepository $livreur;

    public function __construct()
    {
        $this->repo = new CommandeRepository();
        $offre = $this->offre = new OffreRepository();
        $this->livreur = new LivreurRepository();

    }

    /*public function createCommande(int $clientId, string $description) : int
    {
        #validator::validateText($description, 255, "Description");
        #$this->repo->



    }

    public function updateCommande(int $commandeId, array $data) : bool
    {

    }

    public function deleteCommande(int $commandeId) : bool
    {

    }*/

    public function getMyCommandes(int $clientId) : array
    {
        validator::validateExistingClient($clientId, DatabaseConnect::getConnexion());
        return $this->repo->findByClientId($clientId);

    }

    public function getCommandeDetails(int $commandeId) : array | null
    {
        validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        return $this->repo->findById($commandeId);
    }

    public function accepteOffre( int $offreId, int $clientId, int $commandeId) : bool
    {
        validator::validateExistingClient($clientId, DatabaseConnect::getConnexion());
        $commande = $this->repo->findById($commandeId);
        if($commande['client_id'] !== $clientId){
            throw new validationException("vous avez pas l'autorisation d'annuler cette commande ");
        }

        if($commande['is_delete'])
        {
            throw new validationException("commande deja supprimer");
        }
        return $this->repo->updateEtat("Accepter", $commandeId, $clientId);
    }
    public function getNotifications(int $clientId) : array
    {
        validator::validateExistingClient($clientId, DatabaseConnect::getConnexion());
        return $this->notif->findByUtilisateurId($clientId);
    }
    public function validateDelivery(int $commandeId) : bool
    {

    }

    public function setNoteMoyenneOfLivreur(float $noteMoyenne, int $livreurId) : bool
    {
        return $this->livreur->updateNote($noteMoyenne,$livreurId);

    }
}
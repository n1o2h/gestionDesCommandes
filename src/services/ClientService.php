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
        $this->notif = new NotificationRepository();

    }

    public function createCommande(int $clientId, string $description) : int
    {
        validator::validateExistingClient($clientId, DatabaseConnect::getConnexion());
        validator::validateText($description, 255, "Description de la commande");
        return $this->repo->save($description, "Crée", $clientId);
    }

    public function update(int $commandeId, int $clientId, string $desc) : bool
    {
        validator::validateText($desc, 255, 'Description');
        $commande= $this->repo->findById($commandeId);
        #validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        validator::validateExistingClient($clientId,DatabaseConnect::getConnexion());
        if($commande['client_id'] !== $clientId){
            throw new validationException("Acces refuse a cette commande");
        }

        if($commande['etat'] !== 'Crée' AND $commande['etat'] !== 'En attente'){
            throw new validationException("nous pouvant pas modifier la commande");
        }
        return $this->repo->update($desc,$commandeId, $clientId);
    }

    public function deleteCommande(int $commandeId, int $clientId): bool
    {
        $commande = $this->repo->findById($commandeId);
        #validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        if($commande['client_id'] !== $clientId){
            throw new validationException("Impossible de supprimer cette commande");
        }
        if($commande['etat'] === 'Accepter')
        {
            throw new validationException("Impossible de supprimer cette commande deja accepte");
        }
        if($commande['is_delete'])
        {
            throw new validationException("commande deja supprimer");
        }
        return $this->repo->softDelete($commandeId);
    }

    public function cancelState(int $commandeId,int $clientId) : bool
    {
        $commande = $this->repo->findById($commandeId);
        if($commande['client_id'] !== $clientId){
            throw new validationException("vous avez pas l'autorisation d'annuler cette commande ");
        }
        if($commande['etat'] !== 'Accepter' )
        {
            throw new validationException("Impossible d'anuller cette commande c'est deja Accepter ");
        }
        if($commande['etat'] === 'annuler' )
        {
            throw new validationException("Impossible d'anuller cette commande c'est deja annuler  ");
        }
        if($commande['is_delete'])
        {
            throw new validationException("commande deja supprimer");
        }
        return $this->repo->cancel($commandeId, $clientId);
    }

    public function getMyCommandes(int $clientId) : array
    {
        validator::validateExistingClient($clientId, DatabaseConnect::getConnexion());
        return $this->repo->findByClientId($clientId);

    }

    public function getCommandeDetails(int $commandeId, int $clientId) : array | null
    {
        validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        $commande = $this->repo->findById($commandeId);
        if ($commande['client_id'] !== $clientId) {
            throw new validationException("Accès refusé à cette commande");
        }
        return $commande;
    }
    public function acceptOffre(int $offreId, int $clientId): bool
    {
        validator::validateExistingOffre($offreId, DatabaseConnect::getConnexion());
        $offre = $this->repo->findById($offreId);
        $commandeId = $offre['commande_id'];
        $this->offre->updateEtat($offreId, 'acceptée');
        $this->offre->refuseOthers($commandeId, $offreId);
        $this->repo->updateEtat('En_cours', $commandeId, $clientId);
        #$this->notif->save("Votre offre a été acceptée");

        return true;
    }


    public function getNotifications(int $clientId) : array
    {
        validator::validateExistingClient($clientId, DatabaseConnect::getConnexion());
        return $this->notif->findByUtilisateurId($clientId);
    }
    public function validateDelivery(int $commandeId, int $clientId) : bool
    {
        validator::validateExistingCommande($commandeId, DatabaseConnect::getConnexion());
        validator::validateExistingClient($clientId, DatabaseConnect::getConnexion());
        $commande = $this->repo->findById($commandeId);
        if($commande["client_id"] !== $clientId){
            throw new validationException("vous avez pas l'autorisation de valider cette commande");
        }
        if ($commande['etat'] === "Crée" || $commande['etat'] === "En_cours"){
            throw new validationException("Impossible de valider la livraisson");
        }
        $offre = $this->offre->findByCommandeId($commandeId);
        if($offre['commande_id'] !== $commandeId){
            throw new validationException("L'offre n'appartient pas a cette commande");
        }
        if($commande['etat'] === "Terminer"){
            throw new validationException("La commande est deja terminer et valider");
        }

        return $this->repo->updateEtat("Terminee", $commandeId, $clientId);
    }

    public function setNoteMoyenneOfLivreur(float $noteMoyenne, int $livreurId) : bool
    {
        return $this->livreur->updateNote($noteMoyenne,$livreurId);
    }


}
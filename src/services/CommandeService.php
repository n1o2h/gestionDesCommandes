<?php

namespace App\services;
use App\config\DatabaseConnect;
use App\Exception\validationException;
use App\repositories\CommandeRepository;
use App\repositories\utilisateurRepository;
use DateTime;

class CommandeService
{
    private CommandeRepository $repo;
    public function __construct()
    {
        $this->repo = new CommandeRepository();
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
        if($commande['etat'] !== 'Accepter' || $commande['etat'] === 'annuler')
        {
            throw new validationException("Impossible d'anuller cette commande c'est deja annuler ou bien Accepter ");
        }
        if($commande['is_delete'])
        {
            throw new validationException("commande deja supprimer");
        }
        return $this->repo->cancel($commandeId, $clientId);
    }


}
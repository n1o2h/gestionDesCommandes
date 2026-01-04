<?php

namespace App\services;
use App\Exception\validationException;

class validator
{
    public static function validateText(string $text, int $maxLength = 255, string $fildName = "Champ"): void
    {
        if (empty($text)) {
            throw new validationException("$fildName est obligatoir");
        }
        if (strlen($text) > $maxLength) {
            throw new validationException("$fildName ne doit pas depasser $maxLength caracteres .");
        }
    }

    public static function validateEmail(string$email) : void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new validationException("Email non valide .");
        }
    }

    public static function validePasword(string $password, int $minLength=8):void
    {
        if(strlen($password) < $minLength){
            throw new validationException("Le mot de passe doit contient au moin 8 caracteres. ");
        }
    }

    public static function validateBool($val, string $fildName = "Champ"):void
    {
        if (!is_bool($val)) {
            throw new validationException("$fildName doit etre un nombre");
        }
    }

    public static function validateDateTime($val, string $fildName = "Champ"): void
    {
        if(!$val instanceof \DateTime){
            throw new validationException("$fildName doit etre un objet Datetime");
        }
    }

    public static function validateRole(string $role):void
    {
        $roles = ['client', 'livreur', 'admin'];
        if(!in_array($role, $roles)){
            throw new validationException("Role invalide");
        }
    }

    public static function validateEtatCommande(string $etat): void
    {
        $etats = ['Créée','En attente','En cours','Expédiée','Terminée','Annulée'];
        if(!in_array($etat, $etats)){
            throw new validationException("Etat de commande invalide");
        }
    }

    public static function validateExistingClient(int $id, $pdo) : void
    {
        $stmt = $pdo->prepare("SELECT id FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        if(!$stmt->fetch()){
            throw new validationException("Client inexistant.");
        }
    }

    public static function validateExistingLivreur(int $id, $pdo) : void
    {
        $stmt = $pdo->prepare("SELECT id FROM livreurs WHERE id = ?");
        $stmt->execute([$id]);
        if(!$stmt->fetch()){
            throw new validationException("Livreur inexistant");
        }
    }

    public static function validateExistingVehicule(int $id, $pdo) : void
    {
        $stmt = $pdo->prepare("SELECT id FROM vehicules WHERE id = ?");
        $stmt->execute([$id]);
        if(!$stmt->fetch()){
            throw new validationException("Vehicule inexistant");
        }
    }
}

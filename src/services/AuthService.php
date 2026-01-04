<?php
namespace App\services;
use App\Exception\validationException;
use App\repositories\ClientRepository;
use App\repositories\LivreurRepository;
use App\repositories\utilisateurRepository;

class AuthService
{
    private utilisateurRepository $repo;
    public function __construct()
    {
        $this->repo = new utilisateurRepository();
    }

    public function registerClient(string $nomComplet, string $email, string $password): int{
        #validation des champs
        validator::validateText($nomComplet, 255 ,"Nom complet");
        validator::validateText($email, 255 ,"Email");
        validator::validateEmail($email);
        validator::validePasword($password);

        #valider si l'utilisateur deja existe
        if($this->repo->findByEmail($email)){
            throw  new validationException("Cet email existe deja");
        }

        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $idUtilisateur  = $this->repo->save($nomComplet,$email, $passHash, 'client', true);

        $clientRepo = new ClientRepository();
        if(!$clientRepo->save($idUtilisateur)){
            throw new validationException("Erreur lors de L'inscription du client");
        }


        return $idUtilisateur;
    }

    public function registerLivreur(string $nomComplet, string $email, string $password, $noteMoyenne = 0): int{
        #validation des champs
        validator::validateText($nomComplet, 255 ,"Nom complet");
        validator::validateText($email, 255 ,"Email");
        validator::validateEmail($email);
        validator::validePasword($password);


        #valider si l'utilisateur deja existe
        if($this->repo->findByEmail($email)){
            throw  new validationException("Cet email existe deja");
        }

        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $idUtilisateur  = $this->repo->save($nomComplet,$email, $passHash, 'Livreur', true);

        $livreurRepo = new LivreurRepository();
        if(!$livreurRepo->save($noteMoyenne, $idUtilisateur)){
            throw new validationException("Erreur lors de L'inscription du livreur");
        }

        return $idUtilisateur;
    }

    public function login(string $email, string $password, string $role): array
    {
        $utilisateur = $this->repo->findByEmail($email);
        if(!$utilisateur || !password_verify($password, $utilisateur['password'])){
            throw new validationException("Email ou mot de passe incorrect");
        }

        if($utilisateur['role'] !== $role){
            throw new validationException("Vous n'avez pas le bon role pour la connexion");
        }
        return $utilisateur;
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
    }



}
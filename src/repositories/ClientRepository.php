<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use PDO;

class ClientRepository
{
    private PDO $pdo;

    public function save(int $utilisateurId) : string
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "INSERT INTO clients (utilisateur_id) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateurId]);
        return  'created ';
    }
    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM clients";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByClientId( int $clientId): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM clients WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$clientId]);
        $data = $stmt->fetch();
        return $data ? $data: null;
    }

    public function findByUtilisateurId(int $utilisateur_id): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT u.*, c.id as Client_id FROM utilisateurs u JOIN clients c ON  u.id = c.utilisateur_id WHERE c.utilisateur_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateur_id]);
        $data = $stmt->fetch();
        return $data ? $data: null;
    }
    public function delete(int $id): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "DELETE FROM clients WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

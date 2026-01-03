<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use PDO;

class AdminRepository
{
    private PDO $pdo;

    public function save(int $utilisateurId) : string
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "INSERT INTO admins (utilisateur_id) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateurId]);
        return  'created ';
    }
    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM admins";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByAdminId( int $admintId): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM admins WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$admintId]);
        return $stmt->fetch();
    }

    public function findByUtilisateurId(int $utilisateur_id): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT u.*, a.id as admin_id FROM utilisateurs u JOIN admins a ON  u.id = a.utilisateur_id WHERE a.utilisateur_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateur_id]);
        return $stmt->fetch();
    }
    public function delete(int $id): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "DELETE FROM admins WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

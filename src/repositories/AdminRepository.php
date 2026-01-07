<?php

namespace App\repositories;

use App\config\DatabaseConnect;
use PDO;

class AdminRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseConnect::getConnexion();
    }

    public function save(int $utilisateurId) : int
    {
        $sql = "INSERT INTO admins (utilisateur_id) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$utilisateurId]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findAll() : array
    {
        $sql = "SELECT u.*, a.id AS admin_id
                FROM admins a
                JOIN utilisateurs u ON u.id = a.utilisateur_id";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $adminId): array | null
    {
        $sql = "SELECT * FROM admins WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$adminId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    public function findByUtilisateurId(int $utilisateurId): array | null
    {
        $sql = "SELECT u.*, a.id AS admin_id
                FROM utilisateurs u
                JOIN admins a ON u.id = a.utilisateur_id
                WHERE a.utilisateur_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$utilisateurId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM admins WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

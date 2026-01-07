<?php

namespace App\repositories;
use App\config\DatabaseConnect;
use PDO;

class LivreurRepository
{
    private PDO $pdo;

    public function save(float $noteMoyenne,int $utilisateurId) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "INSERT INTO livreurs (note_moyenne,utilisateur_id) VALUES (?,?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$noteMoyenne,$utilisateurId]);

    }
    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM livreurs";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByLivreurId( int $livreurId): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM livreurs WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$livreurId]);
        $data = $stmt->fetch();
        return $data ? $data: null;
    }

    public function findByUtilisateurId(int $utilisateur_id): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT u.*, l.id as Livreur_id FROM utilisateurs u JOIN livreurs l ON  u.id = l.utilisateur_id WHERE l.utilisateur_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateur_id]);
        $data = $stmt->fetch();
        return $data ? $data: null;
    }
    public function delete(int $id): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "DELETE FROM livreurs WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function updateNote(float $nouveauNote, int $id): bool
    {
        $pdo=DatabaseConnect::getConnexion();
        $sql = "UPDATE livreurs SET note_moyenne = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$nouveauNote, $id]);
    }

    public function getNoteMoyenne(int $livreurId)
    {
    }
}

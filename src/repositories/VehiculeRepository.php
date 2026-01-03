<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use PDO;

class VehiculeRepository
{
    private PDO $pdo;

    public function save(string $type,string $description, int $livreurId) : string
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "INSERT INTO vehicules (type, description, livreur_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$type, $description, $livreurId]);
        return  'created ';
    }
    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM vehicules";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById( int $id): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM vehicules WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update(string $type,string $descriptiont, int $id) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE vehicules SET type = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$type, $descriptiont, $id]);
    }

    public function delete(int $id): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "DELETE FROM vehicules WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

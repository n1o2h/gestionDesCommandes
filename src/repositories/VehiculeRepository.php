<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use PDO;

class VehiculeRepository
{
    private PDO $pdo;

    public function save(string $type,string $description, int $livreurId) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $livreurExiste = $pdo->prepare("SELECT * FROM vehicules WHERE livreur_id = ?");
        $livreurExiste->execute([$livreurId]);
        if($livreurExiste->fetch()){
          return false;
        }
        $sql = "INSERT INTO vehicules (type, description, livreur_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$type, $description, $livreurId]);
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
        $data = $stmt->fetch();
        return $data ? $data: null;
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

<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use PDO;

class CommandeRepository
{
    private PDO $pdo;

    public function save(string $description, string $etat,int $clientId) : string
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "INSERT INTO commandes (description, etat, client_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$description,$etat, $clientId]);
        return  'created ';
    }
    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM commandes";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById( int $id): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM commandes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update(string $description, string $etat, int $id) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE commandes SET description = ?, etat = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$description, $etat, $id]);
    }

    public function delete(int $id): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "DELETE FROM commandes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

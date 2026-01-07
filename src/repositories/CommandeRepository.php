<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use PDO;

class CommandeRepository
{
    private PDO $pdo;

    public function save(string $description, string $etat,int $clientId) : int
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "INSERT INTO commandes (description, etat, client_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$description,$etat, $clientId]);
        return  $pdo->lastInsertId();
    }
    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM commandes WHERE is_delete = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById( int $id): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM commandes WHERE id = ? AND is_delete = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? $data: null;
    }
    public function findByEtat(): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM commandes WHERE etat = 'Crée' OR etat = 'En_attente' AND is_delete = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data ? $data: null;
    }

    public function findByClientId( int $clientId): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM commandes WHERE client_id = ? AND is_delete = 0";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$clientId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data ? $data: null;
    }



    public function update(string $description, int $id, int $clientId) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE commandes SET description = ? WHERE id = ? AND client_id = ? and etat = 'Crée'";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$description, $id, $clientId]);
    }

    public function updateEtat(string $etat, int $id, int $clientId): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE commandes SET etat = ?  WHERE id = ? And  client_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$etat, $id, $clientId]);
    }


    public function softDelete(int $id): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE commandes SET is_delete = 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function cancel(int $id, int $clientId) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE commandes SET etat = 'annuler' WHERE id = ? AND  client_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id, $clientId]);
    }

}

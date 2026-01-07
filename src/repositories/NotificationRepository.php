<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use DateTime;
use PDO;

class NotificationRepository
{
    private PDO $pdo;

    public function save(string $type, string $message,DateTime $dateEnvoi, bool $lue, int $utilisateurId) : string
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "INSERT INTO notifications (type, message, dure_envoi, est_lue ,utilisateur_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$type, $message, $dateEnvoi->format('Y-m-d H:i:s'), $lue, $utilisateurId]);
        return  'created ';
    }
    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM notifications";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById( int $id): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM notifications WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? $data: null;
    }

    public function findByIdAndType( int $id, string $type): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM notifications WHERE id = ? AND type = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id, $type]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data ? $data: null;
    }


    public function findByUtilisateurId( int $utilisateurId): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM notifications WHERE utilisateur_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateurId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data ? $data: null;
    }
    public function findByClientId(int $utilisateurId) :  array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM notifications  WHERE utilisateur_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateurId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data ? $data: null;
    }

    public function update(string $type, string $message,DateTime $dateEnvoi, bool $lue, int $id) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE notifications SET type = ?, message = ?, dure_envoi = ?, est_lue = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$type, $message, $dateEnvoi->format('Y-m-d H:i:s'), $lue, $id]);
    }

    public function delete(int $id): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "DELETE FROM notifications WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function estLue(int $id) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE notifications SET est_lue = 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

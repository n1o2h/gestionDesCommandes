<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use DateTime;
use PDO;

class OffreRepository
{
    private PDO $pdo;

    public function save(string $prix, DateTime $dureEstime,int $commandeId, int $livreurId, int $vehiculeId, string $etat) : int
    {
        $pdo = DatabaseConnect::getConnexion();

        $sql = "INSERT INTO offres (prix, dure_estime, commande_id,livreur_id,vehicule_id, etat) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prix, $dureEstime->format('Y-m-d H:i:s'), $commandeId, $livreurId, $vehiculeId, $etat]);
        return $pdo->lastInsertId();
    }
    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM offres";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById( int $id): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM offres WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findByCommandeId( int $commandeId): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM offres WHERE commande_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$commandeId]);
        return $stmt->fetch();
    }

    public function findByLivreurId( int $livreurId): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM offres WHERE livreur_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$livreurId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findByLivreurIdAndCommandeId( int $commandeId, int $livreurId): array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM offres WHERE commande_id = ? AND livreur_id= ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$commandeId, $livreurId]);
        return $stmt->fetch();
    }

    public function update(string $prix, DateTime $dureEstime, int $id) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE offres SET prix = ?, dure_estime = ?  WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$prix,  $dureEstime->format('Y-m-d H:i:s'),$id]);
    }

    public function delete(int $id): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "DELETE FROM offres WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function updateEtat(int $offreId, string $etat): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE offres SET etat = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$etat, $offreId]);
    }
    public function refuseOthers(int $commandeId, int $offreId): bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "
        UPDATE offres
        SET etat = 'refusée'
        WHERE commande_id = ?
          AND id != ?
          AND etat = 'en_attente'
    ";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$commandeId, $offreId]);
    }


}

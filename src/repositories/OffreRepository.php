<?php
namespace App\repositories;
use App\config\DatabaseConnect;
use DateTime;
use PDO;

class OffreRepository
{
    private PDO $pdo;

    public function save(string $prix, DateTime $dureEstime,int $commandeId, int $livreurId, int $vehiculeId) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        if(!is_float($prix)){
            throw new \Exception("Le prix doit etre un float");
        }

        $sql = "INSERT INTO offres (prix, dure_estime, commande_id,livreur_id,vehicule_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$prix, $dureEstime->format('Y-m-d H:i:s'), $commandeId, $livreurId, $vehiculeId]);
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
}

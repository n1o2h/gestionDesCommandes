<?php
namespace App\repositories;

use App\models\Utilisateur;
use App\config\DatabaseConnect;
use PDO;

class utilisateurRepository
{
    private PDO $pdo;
    public function save(string $nomComplet, string  $email,  string $password, string $role, bool $active): int
    {
        $pdo = DatabaseConnect::getConnexion();

        $sql = "INSERT INTO utilisateurs (nom_complet, email,password, role, active) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        var_dump($active);
        $stmt->execute([$nomComplet,$email, $password, $role,(int) $active]);
        $idUser = $pdo->lastInsertId();
        return $idUser;
    }

    public function findAll() : array {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM utilisateurs";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id) : ?array
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM utilisateurs WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findByEmail(string $email) : array | null
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch();
        return $data ? $data: null;
    }

    public function update(string $nomComplet, string  $email,string  $password,  string $role,bool $active, int  $id) : bool
    {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "UPDATE utilisateurs SET nom_complet = ? , email = ? , password = ? , role = ? , active = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$nomComplet, $email, $password, $role, $active, $id]);
    }

    public function delete(int $id): bool {
        $pdo = DatabaseConnect::getConnexion();
        $sql = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);

    }
}
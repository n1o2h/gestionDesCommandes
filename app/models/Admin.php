<?php
namespace App\models;
use App\models\Utilisateur;

class Admin extends  Utilisateur
{
    public function __construct(int $id, string $nomComplet, string $email, string $password, string $role, bool $active, \App\models\Notification $listNotification)
    {
        parent::__construct($id, $nomComplet, $email, $password, $role, $active, $listNotification);
    }
}
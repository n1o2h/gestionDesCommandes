<?php
namespace App\services;

use App\repositories\utilisateurRepository;

class NotificationService
{
    private utilisateurRepository $repo;
    public function __construct()
    {
        $this->repo = new utilisateurRepository();
    }

    public function create(string $type, string $message, int $userId, $date = null) : int
    {

    }

    public function  markAsRead(int $notificationId) : bool
    {

    }

    public function getByUser(int $userId) : array
    {

    }

}
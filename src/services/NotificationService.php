<?php
namespace App\services;

use App\repositories\NotificationRepository;
use App\repositories\utilisateurRepository;

class NotificationService
{
    private utilisateurRepository $repo;
    private NotificationRepository $notif;
    public function __construct()
    {
        $this->repo = new utilisateurRepository();
        $this->notif = new NotificationRepository();
    }

    public function create(string $type, string $message, int $userId, $date = null) : int
    {
        validator::validateText($type, 255, "Type de notificatation");
        validator::validateText($message, 255, "Message de notification");
        return 1;

    }

    public function  markAsRead(int $notificationId) : bool
    {
        return $this->notif->estLue($notificationId);
    }

    public function getByUser(int $userId) : array
    {

    }

}
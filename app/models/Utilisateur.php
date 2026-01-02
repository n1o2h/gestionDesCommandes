<?php
namespace  App\models;
use App\models\Notification;

abstract class  Utilisateur
{
    private ?int $id;
    private string $nomComplet;
    private string $email;
    private string $password;
    private string $role;
    private bool $active;
    private array|Notification $listNotification = [];


    public function __construct(int $id, string $nomComplet, string $email, string $password, string $role, bool $active, Notification $listNotification)
    {
        $this->id = $id;
        $this->nomComplet = $nomComplet;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->active = $active;
        $this->listNotification = $listNotification;
    }

    /* getters */
    public function getId(): int|null
    {
        return $this->id;
    }

    public function getNomComplet(): string
    {
        return $this->nomComplet;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getListNotification(): Notification|array
    {
        return $this->listNotification;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    /* setters */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNomComplet(string $nomCompel): void
    {
        $this->nomComplet = $nomCompel;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
        public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setListNotification(Notification|array $listNotification): void
    {
        $this->listNotification = $listNotification;
    }


    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
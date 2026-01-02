<?php
namespace  App\models;
use App\models\Utilisateur;
use DateTime;

class  Notification
{
    private ?int $id;
    private Utilisateur $utilisateur;
    private string $type;
    private string $message;
    private DateTime $dureEnvoi;
    private bool $lue;

    public function  __construct(int $id, Utilisateur $utilisateur, string $type, string $message, DateTime $dureEnvoi, bool $lue)
    {
        $this->id = $id;
        $this->utilisateur = $utilisateur;
        $this->type = $type;
        $this->message = $message;
        $this->dureEnvoi = $dureEnvoi;
        $this->lue = $lue;
    }

    /* getters */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDureEnvoi(): DateTime
    {
        return $this->dureEnvoi;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }
    public function getLue(): bool
    {
        return $this->lue;
    }

    /* setters */

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setDureEnvoi(DateTime $dureEnvoi): void
    {
        $this->dureEnvoi = $dureEnvoi;
    }

    public function setLue(bool $lue): void
    {
        $this->lue = $lue;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setUtilisateur(Utilisateur $utilisateur): void
    {
        $this->utilisateur = $utilisateur;
    }
}
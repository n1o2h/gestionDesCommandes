<?php

namespace  App\models;

class Vehicule
{
    private ?int $id;
    private string $type;
    private string $description;

    public function __construct(int $id, string $type, string $description){
        $this->id = $id;
        $this->type = $type;
        $this->description = $description;
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

    public function getDescription(): string
    {
        return $this->description;
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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

}
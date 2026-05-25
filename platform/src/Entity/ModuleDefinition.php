<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ModuleDefinition
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    public string $code;

    #[ORM\Column(length: 255)]
    public string $name;

    #[ORM\Column(type: 'text')]
    public string $description;

    #[ORM\Column(length: 100)]
    public string $workerRoute = '';

    #[ORM\Column(type: 'json', nullable: true)]
    public ?array $capabilities = null;

    #[ORM\Column]
    public bool $available = true;
}
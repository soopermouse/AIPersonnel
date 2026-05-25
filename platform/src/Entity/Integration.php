<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Integration
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class, nullable: true)]
    public ?Organization $organization = null;

    #[ORM\Column(length: 100)]
    public string $provider;

    #[ORM\Column(length: 100)]
    public string $type;

    #[ORM\Column(type: 'json')]
    public array $config = [];

    #[ORM\Column]
    public bool $enabled = false;

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
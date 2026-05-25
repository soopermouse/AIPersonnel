<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ModuleJob
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 100)]
    public string $moduleCode;

    #[ORM\Column(length: 100)]
    public string $jobType;

    #[ORM\Column(type: 'json')]
    public array $payload = [];

    #[ORM\Column(length: 50)]
    public string $status = 'queued';

    #[ORM\Column(type: 'json', nullable: true)]
    public ?array $result = null;

    #[ORM\Column(type: 'text', nullable: true)]
    public ?string $errorMessage = null;

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    public ?\DateTimeImmutable $completedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
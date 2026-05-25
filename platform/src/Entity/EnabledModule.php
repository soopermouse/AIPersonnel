<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class EnabledModule
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    public Organization $organization;

    #[ORM\ManyToOne(targetEntity: ModuleDefinition::class)]
    public ModuleDefinition $module;

    #[ORM\Column]
    public bool $enabled = true;

    #[ORM\Column(type: 'json', nullable: true)]
    public ?array $settings = null;

    #[ORM\Column]
    public \DateTimeImmutable $enabledAt;

    public function __construct()
    {
        $this->enabledAt = new \DateTimeImmutable();
    }
}
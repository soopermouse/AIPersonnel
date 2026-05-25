<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Organization
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public string $name;

    #[ORM\Column(length: 50)]
    public string $countryCode = 'NL';

    #[ORM\Column(length: 3)]
    public string $currency = 'EUR';

    #[ORM\Column(type: 'json', nullable: true)]
    public ?array $settings = null;

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
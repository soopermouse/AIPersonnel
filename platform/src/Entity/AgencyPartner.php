<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AgencyPartner
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    public Organization $organization;

    #[ORM\Column(length:255)]
    public string $name;

    #[ORM\Column(length:255, nullable:true)]
    public ?string $contactName = null;

    #[ORM\Column(length:255, nullable:true)]
    public ?string $contactEmail = null;

    #[ORM\Column(length:50)]
    public string $status = 'preferred';

    #[ORM\Column(type:'decimal', precision:10, scale:2, nullable:true)]
    public ?string $defaultMarkupPercent = null;

    #[ORM\Column(type:'json', nullable:true)]
    public ?array $metadata = null;

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
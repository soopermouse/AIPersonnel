<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Candidate
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    public Organization $organization;

    #[ORM\Column(length:255)]
    public string $fullName;

    #[ORM\Column(length:255)]
    public string $email;

    #[ORM\Column(length:50)]
    public string $source = 'direct';

    #[ORM\ManyToOne(targetEntity: AgencyPartner::class)]
    public ?AgencyPartner $agency = null;

    #[ORM\Column(length:100, nullable:true)]
    public ?string $roleAppliedFor = null;

    #[ORM\Column(length:50)]
    public string $status = 'new';

    #[ORM\Column(type:'json', nullable:true)]
    public ?array $skills = null;

    #[ORM\Column(type:'text', nullable:true)]
    public ?string $notes = null;

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
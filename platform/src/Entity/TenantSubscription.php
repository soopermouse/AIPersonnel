<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TenantSubscription
{
    public const PLAN_BASIC = 'basic';
    public const PLAN_ADVANCED = 'advanced';
    public const PLAN_ENTERPRISE = 'enterprise';

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    public Organization $organization;

    #[ORM\Column(length:50)]
    public string $plan = self::PLAN_BASIC;

    #[ORM\Column(length:50)]
    public string $status = 'trial';

    #[ORM\Column(nullable:true)]
    public ?\DateTimeImmutable $trialEndsAt = null;

    #[ORM\Column(nullable:true)]
    public ?\DateTimeImmutable $currentPeriodEndsAt = null;

    #[ORM\Column(type:'json', nullable:true)]
    public ?array $billingMetadata = null;

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->trialEndsAt = new \DateTimeImmutable('+14 days');
    }
}
<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TempStaffAssignment
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    public Organization $organization;

    #[ORM\ManyToOne(targetEntity: EmployeeRecord::class)]
    public EmployeeRecord $worker;

    #[ORM\ManyToOne(targetEntity: AgencyPartner::class)]
    public ?AgencyPartner $agency = null;

    #[ORM\Column(length:255)]
    public string $assignmentTitle;

    #[ORM\Column(length:100, nullable:true)]
    public ?string $projectCode = null;

    #[ORM\Column(length:255, nullable:true)]
    public ?string $customerName = null;

    #[ORM\Column(type:'decimal', precision:10, scale:2)]
    public string $hourlyPayRate = '0.00';

    #[ORM\Column(type:'decimal', precision:10, scale:2, nullable:true)]
    public ?string $billableClientRate = null;

    #[ORM\Column]
    public \DateTimeImmutable $startsAt;

    #[ORM\Column(nullable:true)]
    public ?\DateTimeImmutable $endsAt = null;

    #[ORM\Column(length:50)]
    public string $status = 'active';

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
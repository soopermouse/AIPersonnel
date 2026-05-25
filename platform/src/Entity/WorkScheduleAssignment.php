<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class WorkScheduleAssignment
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    public Organization $organization;

    #[ORM\ManyToOne(targetEntity: EmployeeRecord::class)]
    public EmployeeRecord $employee;

    #[ORM\Column(length:255)]
    public string $title;

    #[ORM\Column]
    public \DateTimeImmutable $startsAt;

    #[ORM\Column]
    public \DateTimeImmutable $endsAt;

    #[ORM\Column(length:50)]
    public string $workType = 'company_time';

    #[ORM\Column(length:255, nullable:true)]
    public ?string $customerName = null;

    #[ORM\Column(length:100, nullable:true)]
    public ?string $projectCode = null;

    #[ORM\Column(type:'decimal', precision:10, scale:2, nullable:true)]
    public ?string $billableRate = null;

    #[ORM\Column(type:'json', nullable:true)]
    public ?array $metadata = null;

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class BillableTimeEntry {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\ManyToOne(targetEntity: EmployeeRecord::class, nullable:true)] public ?EmployeeRecord $employee = null;
    #[ORM\Column(length:255)] public string $customerName;
    #[ORM\Column(length:255, nullable:true)] public ?string $customerContract = null;
    #[ORM\Column(length:255)] public string $projectName;
    #[ORM\Column(length:100)] public string $projectCode;
    #[ORM\Column] public \DateTimeImmutable $workDate;
    #[ORM\Column(type:'decimal', precision:8, scale:2)] public string $billableHours = '0.00';
    #[ORM\Column(type:'decimal', precision:8, scale:2)] public string $companyHours = '0.00';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $billingRate = '0.00';
    #[ORM\Column(type:'decimal', precision:5, scale:2)] public string $taxRate = '21.00';
    #[ORM\Column(length:50)] public string $status = 'draft';
    public function __construct(){ $this->workDate = new \DateTimeImmutable(); }
}
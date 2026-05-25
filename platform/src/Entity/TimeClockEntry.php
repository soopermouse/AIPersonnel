<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TimeClockEntry {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\ManyToOne(targetEntity: EmployeeRecord::class)] public EmployeeRecord $employee;
    #[ORM\Column] public \DateTimeImmutable $clockInAt;
    #[ORM\Column(nullable:true)] public ?\DateTimeImmutable $clockOutAt = null;
    #[ORM\Column(type:'decimal', precision:8, scale:2)] public string $hoursWorked = '0.00';
    #[ORM\Column(length:50)] public string $status = 'open';
    #[ORM\Column(type:'text', nullable:true)] public ?string $notes = null;
    public function __construct(){ $this->clockInAt = new \DateTimeImmutable(); }
}
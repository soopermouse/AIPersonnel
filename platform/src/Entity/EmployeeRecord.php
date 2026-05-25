<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class EmployeeRecord {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\ManyToOne(targetEntity: EmployeeRole::class, nullable:true)] public ?EmployeeRole $role = null;
    #[ORM\Column(length:255)] public string $name;
    #[ORM\Column(length:255, nullable:true)] public ?string $email = null;
    #[ORM\Column(length:2)] public string $countryCode = 'NL';
    #[ORM\Column(length:50)] public string $employmentType = 'employee';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $monthlyWage = '0.00';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $hourlyRate = '0.00';
    #[ORM\Column(length:100, nullable:true)] public ?string $taxCode = null;
    #[ORM\Column(type:'json', nullable:true)] public ?array $benefits = null;
    #[ORM\Column] public bool $active = true;
    #[ORM\Column] public \DateTimeImmutable $createdAt;
    public function __construct(){ $this->createdAt = new \DateTimeImmutable(); }
}
<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class EmployeeRole {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\Column(length:100)] public string $code;
    #[ORM\Column(length:255)] public string $title;
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $defaultMonthlyWage = '0.00';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $defaultHourlyRate = '0.00';
    #[ORM\Column(type:'json', nullable:true)] public ?array $defaultBenefits = null;
    #[ORM\Column] public bool $active = true;
}
<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Vacancy {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\Column(length:255)] public string $title;
    #[ORM\Column(length:100)] public string $roleCode;
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $wageOrRate = '0.00';
    #[ORM\Column(length:50)] public string $contractType = 'employee';
    #[ORM\Column(type:'json', nullable:true)] public ?array $benefits = null;
    #[ORM\Column(type:'decimal', precision:8, scale:2)] public string $hoursPerWeek = '40.00';
    #[ORM\Column(length:50)] public string $status = 'open';
    #[ORM\Column(type:'text', nullable:true)] public ?string $description = null;
}
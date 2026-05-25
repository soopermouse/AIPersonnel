<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class BenefitPolicy {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\Column(length:100)] public string $code;
    #[ORM\Column(length:255)] public string $label;
    #[ORM\Column(length:50)] public string $type = 'pension';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $amount = '0.00';
    #[ORM\Column(type:'decimal', precision:5, scale:2)] public string $percent = '0.00';
    #[ORM\Column] public bool $taxable = false;
    #[ORM\Column] public bool $active = true;
}
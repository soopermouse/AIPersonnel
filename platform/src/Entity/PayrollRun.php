<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class PayrollRun {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\Column(length:7)] public string $period;
    #[ORM\Column(length:2)] public string $countryCode = 'NL';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $grossPay = '0.00';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $employeeTaxes = '0.00';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $employerTaxes = '0.00';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $benefitsCost = '0.00';
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $netPay = '0.00';
    #[ORM\Column(type:'json', nullable:true)] public ?array $details = null;
    #[ORM\Column(length:50)] public string $status = 'draft';
    #[ORM\Column] public \DateTimeImmutable $createdAt;
    public function __construct(){ $this->createdAt = new \DateTimeImmutable(); }
}
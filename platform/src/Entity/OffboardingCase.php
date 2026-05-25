<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class OffboardingCase {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\Column(length:255)] public string $name;
    #[ORM\Column(type:'text')] public string $reason;
    #[ORM\Column(type:'decimal', precision:10, scale:2)] public string $compensation = '0.00';
    #[ORM\Column(type:'json', nullable:true)] public ?array $assetsToRetrieve = null;
    #[ORM\Column(type:'json', nullable:true)] public ?array $tasks = null;
    #[ORM\Column(length:50)] public string $status = 'pending';
}
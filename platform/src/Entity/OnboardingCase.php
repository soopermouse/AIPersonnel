<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class OnboardingCase {
    #[ORM\Id, ORM\GeneratedValue, ORM\Column] public ?int $id = null;
    #[ORM\Column(length:255)] public string $name;
    #[ORM\Column(length:255)] public string $roleTitle;
    #[ORM\Column] public \DateTimeImmutable $startDate;
    #[ORM\Column(type:'json', nullable:true)] public ?array $assetsToIssue = null;
    #[ORM\Column(type:'json', nullable:true)] public ?array $tasks = null;
    #[ORM\Column(length:50)] public string $status = 'pending';
    public function __construct(){ $this->startDate = new \DateTimeImmutable(); }
}
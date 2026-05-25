<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class TeamEvaluation
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: EmployeeRecord::class)]
    public EmployeeRecord $employee;

    #[ORM\Column(length:255)]
    public string $teamLeadName;

    #[ORM\Column(length:100, nullable:true)]
    public ?string $teamName = null;

    #[ORM\Column(type:'integer')]
    public int $performanceScore = 5;

    #[ORM\Column(type:'integer')]
    public int $reliabilityScore = 5;

    #[ORM\Column(type:'integer')]
    public int $teamFitScore = 5;

    #[ORM\Column(type:'text', nullable:true)]
    public ?string $comments = null;

    #[ORM\Column(length:50)]
    public string $approvalRecommendation = 'continue';

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
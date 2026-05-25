<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class InterviewProcess
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Candidate::class)]
    public Candidate $candidate;

    #[ORM\Column(length:50)]
    public string $stage = 'screening';

    #[ORM\Column(nullable:true)]
    public ?\DateTimeImmutable $scheduledAt = null;

    #[ORM\Column(length:255, nullable:true)]
    public ?string $interviewerName = null;

    #[ORM\Column(length:255, nullable:true)]
    public ?string $teamLeadName = null;

    #[ORM\Column(type:'text', nullable:true)]
    public ?string $feedback = null;

    #[ORM\Column(type:'integer', nullable:true)]
    public ?int $score = null;

    #[ORM\Column(length:50)]
    public string $decision = 'pending';

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
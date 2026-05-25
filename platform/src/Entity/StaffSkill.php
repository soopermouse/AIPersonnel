<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class StaffSkill
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: EmployeeRecord::class)]
    public EmployeeRecord $employee;

    #[ORM\ManyToOne(targetEntity: Skill::class)]
    public Skill $skill;

    #[ORM\Column(length:50)]
    public string $level = 'working';

    #[ORM\Column(nullable:true)]
    public ?\DateTimeImmutable $verifiedAt = null;

    #[ORM\Column(length:255, nullable:true)]
    public ?string $verifiedBy = null;
}
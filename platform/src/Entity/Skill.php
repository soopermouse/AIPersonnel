<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Skill
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    public Organization $organization;

    #[ORM\Column(length:120)]
    public string $name;

    #[ORM\Column(length:50)]
    public string $category = 'general';

    #[ORM\Column(type:'text', nullable:true)]
    public ?string $description = null;
}
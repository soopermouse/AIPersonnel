<?php
namespace App\Service;

use App\Entity\EmployeeRecord;
use App\Entity\Organization;
use App\Entity\TenantSubscription;
use Doctrine\ORM\EntityManagerInterface;

class StaffPlanLimitService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function getStaffLimit(string $plan): ?int
    {
        return match ($plan) {
            TenantSubscription::PLAN_BASIC => 9,
            TenantSubscription::PLAN_ADVANCED => 99,
            TenantSubscription::PLAN_ENTERPRISE => null,
            default => 9,
        };
    }

    public function describePlan(string $plan): string
    {
        return match ($plan) {
            TenantSubscription::PLAN_BASIC => 'Basic: fewer than 10 total staff',
            TenantSubscription::PLAN_ADVANCED => 'Advanced: fewer than 100 total staff',
            TenantSubscription::PLAN_ENTERPRISE => 'Enterprise: 100+ staff, custom terms',
            default => 'Basic: fewer than 10 total staff',
        };
    }

    public function currentStaffCount(Organization $organization): int
    {
        return (int) $this->em
            ->getRepository(EmployeeRecord::class)
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.organization = :org')
            ->andWhere('e.status != :status')
            ->setParameter('org', $organization)
            ->setParameter('status', 'offboarded')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function canAddStaff(Organization $organization, string $plan): bool
    {
        $limit = $this->getStaffLimit($plan);

        if ($limit === null) {
            return true;
        }

        return $this->currentStaffCount($organization) < $limit;
    }

    public function assertCanAddStaff(Organization $organization, string $plan): void
    {
        if (!$this->canAddStaff($organization, $plan)) {
            throw new \RuntimeException(sprintf(
                'Staff limit reached for %s. Upgrade plan required.',
                $this->describePlan($plan)
            ));
        }
    }
}
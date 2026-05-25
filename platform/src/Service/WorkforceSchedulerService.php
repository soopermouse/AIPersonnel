<?php
namespace App\Service;

use App\Entity\EmployeeRecord;
use App\Entity\WorkScheduleAssignment;
use Doctrine\ORM\EntityManagerInterface;

class WorkforceSchedulerService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function hasOverlap(EmployeeRecord $employee, \DateTimeImmutable $start, \DateTimeImmutable $end): bool
    {
        $count = $this->em
            ->getRepository(WorkScheduleAssignment::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->where('s.employee = :employee')
            ->andWhere('s.startsAt < :end')
            ->andWhere('s.endsAt > :start')
            ->setParameter('employee', $employee)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getSingleScalarResult();

        return ((int) $count) > 0;
    }

    public function calculateHours(WorkScheduleAssignment $assignment): float
    {
        $seconds = $assignment->endsAt->getTimestamp() - $assignment->startsAt->getTimestamp();
        return round(max(0, $seconds) / 3600, 2);
    }

    public function isOvertime(float $scheduledHoursForWeek): bool
    {
        return $scheduledHoursForWeek > 40.0;
    }
}
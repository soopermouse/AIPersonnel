<?php
namespace App\Service;

use App\Entity\TempStaffAssignment;

class TempStaffCostingService
{
    public function calculatePayAsYouGoCost(TempStaffAssignment $assignment, float $hours): array
    {
        $payRate = (float) $assignment->hourlyPayRate;
        $clientRate = $assignment->billableClientRate !== null ? (float) $assignment->billableClientRate : null;

        $workerCost = round($payRate * $hours, 2);
        $clientRevenue = $clientRate !== null ? round($clientRate * $hours, 2) : null;
        $grossMargin = $clientRevenue !== null ? round($clientRevenue - $workerCost, 2) : null;

        return [
            'hours' => $hours,
            'worker_cost' => $workerCost,
            'client_revenue' => $clientRevenue,
            'gross_margin' => $grossMargin,
        ];
    }
}
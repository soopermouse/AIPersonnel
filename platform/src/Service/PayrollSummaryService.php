<?php
namespace App\Service;

class PayrollSummaryService
{
    public function estimatePayroll(array $employees): array
    {
        $gross = 0.0;
        $benefits = 0.0;

        foreach ($employees as $employee) {
            $gross += (float) ($employee['monthly_wage'] ?? 0);
            $benefits += (float) ($employee['benefits_cost'] ?? 0);
        }

        return [
            'gross_pay' => round($gross, 2),
            'benefits_cost' => round($benefits, 2),
            'estimated_total_company_cost' => round($gross + $benefits, 2),
        ];
    }
}
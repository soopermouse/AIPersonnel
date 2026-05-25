<?php
namespace App\Service;

class BillableTimeCalculator
{
    public function calculate(float $billableHours, float $companyHours, float $billingRate, float $taxRate): array
    {
        $net = round($billableHours * $billingRate, 2);
        $tax = round($net * ($taxRate / 100), 2);

        return [
            'billable_net' => $net,
            'tax_amount' => $tax,
            'billable_gross' => round($net + $tax, 2),
            'company_hours' => round($companyHours, 2),
            'total_hours' => round($billableHours + $companyHours, 2),
        ];
    }
}
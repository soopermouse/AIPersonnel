<?php

namespace App\Service;

class ModuleRegistry
{
    public function defaultModules(): array
    {
        return [
            'nxd_tax' => [
                'name' => 'NXDTax',
                'description' => 'Tax, freelance contracts, timesheets, invoices, expenses and payment reserve calculations.',
                'worker_route' => '/api/modules/nxd_tax',
                'capabilities' => ['tax', 'contracts', 'timesheets', 'invoices', 'expenses'],
            ],
            'sales' => [
                'name' => 'Sales',
                'description' => 'Online-shop sales ingestion, VAT, revenue, supply/demand, and sales reporting.',
                'worker_route' => '/api/modules/sales',
                'capabilities' => ['orders', 'vat', 'revenue', 'demand'],
            ],
            'inventory' => [
                'name' => 'Inventory',
                'description' => 'Stock, reorder points, product costs, inventory valuation and logistics handoff.',
                'worker_route' => '/api/modules/inventory',
                'capabilities' => ['stock', 'reorder', 'costs', 'valuation'],
            ],
            'daily_reports' => [
                'name' => 'Daily Reports',
                'description' => 'Daily AI summaries for sales, logistics, stock, finance and industry news.',
                'worker_route' => '/api/modules/daily_reports',
                'capabilities' => ['summaries', 'alerts', 'industry_news'],
            ],
        ];
    }
}
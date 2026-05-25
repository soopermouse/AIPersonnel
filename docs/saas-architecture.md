# AI Personnel™ SaaS Architecture

AI Personnel is extracted from the NXDOne HR/personnel/payroll module and made self-sufficient as a SaaS product.

## Product Boundary

Included:

- Personnel records
- Roles and wages
- Temporary/hourly staff
- Benefits
- Onboarding
- Offboarding
- Clock-in / clock-out
- Billable time
- Scheduler
- Payroll
- Tax code scaffolding
- Tenant subscriptions
- Staff plan limits

Excluded:

- Sales
- Warehouse
- Inventory
- Pricing
- Customer support
- Build-to-order
- General ERP modules

## SaaS Plans

| Plan | Staff Limit |
|---|---:|
| Basic | fewer than 10 total staff |
| Advanced | fewer than 100 total staff |
| Enterprise | 100+ staff |

Staff count includes active employees, contractors, temporary staff, and hourly workers.

## Tenancy Model

MVP tenancy is organisation-scoped.

Recommended production hardening:

- add tenant_id to all HR/payroll/schedule tables
- enforce tenant scoping at repository/service level
- add user-to-tenant membership table
- add RBAC
- add audit logs
- add billing subscription table linked to tenant

## Worker Model

The Python HR/payroll worker performs calculation-heavy operations:

- payroll calculations
- country tax code scaffolding
- billable time calculations
- time classification

The Symfony platform remains the source of truth.
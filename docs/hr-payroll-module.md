# NXDOne HR & Payroll Module

Includes:

- Employee list
- Settable employee roles
- Monthly wages
- Hourly temp staff
- Benefits: pensions, travel expenses, holidays
- HR dashboard
- Digital clock-in / clock-out
- Payroll run scaffolding
- NL / UK / US tax-code worker scaffold
- Billable time and company time provisions for Build-to-Order/Services
- Recruitment dashboard with vacancies, roles, wages/rates, benefits, hours
- Onboarding dashboard with assets/tasks
- Offboarding dashboard with reason, compensation, asset retrieval

## Worker

Runs on port 8040.

Endpoints:

- `/api/hr/payroll/calculate`
- `/api/hr/billable-time/calculate`
- `/api/hr/tax-codes/supported`

Tax logic is scaffold-only. Production requires verified NL, UK, and US payroll tax tables.
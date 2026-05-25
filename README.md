# AI Personnel™

**AI Personnel™** is a multi-tenant SaaS workforce management platform extracted from the NXDOne HR, scheduler, and payroll modules.

Domain target:

```text
https://aipersonnel.online
```

AI Personnel focuses only on:

- personnel records
- employee roles and wages
- temporary/hourly staff
- benefits
- onboarding
- offboarding
- clock-in / clock-out
- billable and company time
- workforce scheduler
- payroll calculations
- country tax-code scaffolding
- SaaS tenant plans and staff limits

This repository intentionally excludes unrelated NXDOne ERP modules.

---

## SaaS Plan Limits

| Plan | Staff Limit | Intended Customer |
|---|---:|---|
| Basic | fewer than 10 total staff | freelancers, micro-businesses, small teams |
| Advanced | fewer than 100 total staff | growing agencies and SMEs |
| Enterprise | 100+ staff | larger organisations requiring custom terms |

Staff count includes employees, temporary staff, contractors, and active workers.

---

## Architecture

```text
AI Personnel
├── platform/                 Symfony frontend/backend
│   ├── src/Entity            HR, payroll, tenant and scheduler entities
│   ├── src/Controller        Symfony controllers
│   ├── src/Service           Staff limits, payroll, scheduler services
│   └── templates             Twig UI
├── workers/
│   └── hr_payroll_worker     Python FastAPI payroll/time worker
├── docs                      SaaS, deployment and module docs
└── docker-compose.yml
```

---

## Tech Stack

### Platform

- PHP 8.3+
- Symfony
- Doctrine ORM
- Twig
- MariaDB / MySQL
- Docker

### Worker Layer

- Python 3.12+
- FastAPI
- Pydantic
- HR/payroll calculation services
- Tax-code abstraction layer

### SaaS Layer

- Tenant-aware data model
- Staff-plan enforcement
- Basic / Advanced / Enterprise plans
- Subscription-ready architecture

---

## Core Modules

### Personnel

- employee records
- roles and wages
- hourly/temp staff
- departments
- contract metadata
- benefits
- onboarding
- offboarding

### Scheduler

- workforce availability
- scheduled work blocks
- billable vs company time
- overtime indicators
- employee assignment

### Payroll

- gross/net calculation scaffolding
- country tax-code abstraction
- overtime handling
- temp/hourly worker support
- payroll period calculations

### Time Tracking

- clock-in / clock-out
- billable time
- non-billable company time
- project/customer references
- timesheet data for payroll

---

## Local Development

```bash
cp .env.example .env
docker compose up -d --build
```

Then install PHP dependencies inside the platform container or locally:

```bash
cd platform
composer install
php bin/console doctrine:migrations:migrate
symfony server:start
```

Run the worker:

```bash
cd workers/hr_payroll_worker
pip install -r requirements.txt
uvicorn app.main:app --host 0.0.0.0 --port 8050
```

---

## Environment Variables

```env
APP_ENV=dev
APP_SECRET=change-me
DATABASE_URL=mysql://aipersonnel:aipersonnel@db:3306/aipersonnel
HR_PAYROLL_WORKER_URL=http://hr-payroll-worker:8050
APP_DOMAIN=aipersonnel.online
```

---

## Trademark Notice

**AI Personnel™** and associated branding, naming, product identity, logos, platform language, and commercial identity are claimed as trademarks by Simona / NXD Tech.

No rights are granted to use the **AI Personnel™** name, brand identity, or related marks for competing products, commercial derivative platforms, or third-party SaaS offerings without explicit written permission.

---

## Copyright

Copyright © 2026 Simona / NXD Tech. All rights reserved unless otherwise specified.

---

## Status

This is an extracted SaaS scaffold based on the NXDOne HR/payroll/personnel architecture.

The goal is to make the personnel, scheduler, and payroll modules self-sufficient while preserving their NXDOne architectural origin.
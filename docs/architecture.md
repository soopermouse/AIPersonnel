# NXDOne Base Architecture

NXDOne is the parent ERP platform.

## Core

Symfony owns:

- organizations
- module registry
- integrations
- dashboard shell
- queue jobs
- calling worker gateway

Python worker gateway owns:

- route module jobs
- expose stable worker API
- forward future work to specialised module workers

## Module Strategy

Each module will have:

- Symfony domain entities
- Symfony UI/controllers
- Python worker module
- scheduled jobs
- daily reports
- integration adapters

## Initial module order

1. Sales module
2. Inventory module
3. Logistics module
4. Daily reports module
5. Industry news module
6. NXDTax integration
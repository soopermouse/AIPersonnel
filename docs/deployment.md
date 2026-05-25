# AI Personnel™ Deployment

## Local Docker

```bash
cp .env.example .env
docker compose up -d --build
```

Platform:

```text
http://localhost:8088
```

Worker:

```text
http://localhost:8050
```

## Manual Symfony Setup

```bash
cd platform
composer install
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate
symfony server:start
```

## Worker Setup

```bash
cd workers/hr_payroll_worker
python -m venv .venv
.venv/scripts/activate
pip install -r requirements.txt
uvicorn app.main:app --host 0.0.0.0 --port 8050
```

## Production Notes

Recommended:

- HTTPS
- managed MariaDB/PostgreSQL
- background queue
- tenant-aware audit logging
- billing provider integration
- backups
- RBAC
- monitoring
- worker health checks
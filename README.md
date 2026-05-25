# AI Personnel™ Temp Staff Patch

Adds temp staff, agency workers, preferred agencies, recruitment, interviews, skills, team evaluations, and team leadership workflows to the AI Personnel SaaS scaffold.

## Apply

Copy the `platform/` directory over the existing AI Personnel scaffold.

Then run:

```bash
cd platform
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Added Routes

- `/temp-staff`
- `/recruitment`
- `/team/evaluations`

## Notes

This patch adds the domain model and UI scaffolding. The next hardening step is RBAC enforcement for team leads and agency contacts.
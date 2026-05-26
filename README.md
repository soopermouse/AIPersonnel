Copyright © 2026 Simona Diana Thrussell PhD / NXDTech. All rights reserved.

This software, platform architecture, source code, workflows, AI orchestration systems, documentation, interfaces, business logic, and associated materials are the intellectual property of Simona Diana Thrussell PhD and NXDTech.

No part of this project may be copied, reproduced, distributed, modified, reverse engineered, sublicensed, or commercially used without prior written permission from the copyright holder.

For licensing, commercial usage, partnership inquiries, or purchase information, please contact:

info@nxdtech.com

Websites:
https://sdtrussell.nl
https://nxdtech.com

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

# AI Personnel™ Temp Staff, Agencies, Recruitment and Team Evaluation Patch

This patch adds a complete temporary staffing and recruitment workflow layer to AI Personnel.

## Added Scope

### Pay-As-You-Go Temp Staff

- temporary staff assignments
- hourly worker cost tracking
- billable client rate
- project/customer assignment
- active/ended assignment state
- direct temp workers or agency-supplied workers

### Agency Workers

- agency partner records
- preferred agencies
- approved agencies
- blocked agencies
- agency contact person
- default markup percentage
- agency-linked candidates and temp assignments

### Recruitment / Interview Process

- candidates
- candidate source
- agency referrals
- skills list
- interview stages
- team interview support
- approval workflow
- score and feedback
- hiring decision state

### Skills

- skill catalogue
- employee skill assignment
- skill levels
- verification metadata

### Team Evaluation

- team-lead feedback
- performance score
- reliability score
- team-fit score
- approval recommendation
- do-not-rehire recommendation
- HR review triggers

### Team Leadership Access

This patch adds the data and screens needed for team leads to evaluate staff.

Recommended next step:
- add RBAC roles:
  - tenant_admin
  - hr_manager
  - payroll_admin
  - team_lead
  - employee
  - agency_contact

Team leads should be able to:
- view assigned team members
- submit evaluations
- approve timesheets for their team
- comment on temp staff suitability
- recommend extension or non-renewal

They should not be able to:
- view full payroll
- change salaries
- change subscription plan
- approve their own payroll
- access unrelated teams

## Files Added

```text
platform/src/Entity/AgencyPartner.php
platform/src/Entity/Skill.php
platform/src/Entity/StaffSkill.php
platform/src/Entity/TempStaffAssignment.php
platform/src/Entity/Candidate.php
platform/src/Entity/InterviewProcess.php
platform/src/Entity/TeamEvaluation.php

platform/src/Controller/TempStaffController.php

platform/src/Service/TempStaffCostingService.php
platform/src/Service/RecruitmentWorkflowService.php

platform/templates/temp_staff/index.html.twig
platform/templates/recruitment/index.html.twig
platform/templates/team/evaluations.html.twig
```

## Routes Added

```text
/temp-staff
/recruitment
/team/evaluations
```

## Business Logic

### Pay-as-you-go model

A temp staff assignment stores:

- worker
- agency, optional
- hourly pay rate
- billable client rate
- project code
- customer name
- assignment period
- status

This allows AI Personnel to calculate:

- hourly labour cost
- client revenue
- margin
- project staffing cost

### Recruitment pipeline

Candidate status can move through:

```text
new → screening → team_interview → approval → offer → approved
```

Rejected candidates can be marked:

```text
rejected
```

### Team approval

Team evaluations allow practical workforce feedback before HR/payroll decisions are finalized.

This is important for:
- temp staff renewal
- permanent hiring
- assignment extension
- agency quality scoring
- do-not-rehire decisions

## Recommended Next Patch

Add:

- RBAC role enforcement
- team membership table
- team lead dashboard
- timesheet approval by team lead
- agency scorecards
- candidate-to-employee conversion
- temp assignment to payroll integration
- agency invoice reconciliation
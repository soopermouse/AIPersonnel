<?php
namespace App\Controller;

use App\Entity\EmployeeRole;
use App\Entity\EmployeeRecord;
use App\Entity\BenefitPolicy;
use App\Entity\TimeClockEntry;
use App\Entity\BillableTimeEntry;
use App\Entity\Vacancy;
use App\Entity\OnboardingCase;
use App\Entity\OffboardingCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HrPayrollController extends AbstractController
{
    #[Route('/hr', name: 'app_hr')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        return $this->render('hr/index.html.twig', [
            'employees' => $em->getRepository(EmployeeRecord::class)->findBy([], ['createdAt' => 'DESC']),
            'roles' => $em->getRepository(EmployeeRole::class)->findAll(),
            'benefits' => $em->getRepository(BenefitPolicy::class)->findAll(),
            'timeEntries' => $em->getRepository(TimeClockEntry::class)->findBy([], ['clockInAt' => 'DESC'], 20),
            'billableEntries' => $em->getRepository(BillableTimeEntry::class)->findBy([], ['workDate' => 'DESC'], 20),
            'vacancies' => $em->getRepository(Vacancy::class)->findAll(),
            'onboarding' => $em->getRepository(OnboardingCase::class)->findAll(),
            'offboarding' => $em->getRepository(OffboardingCase::class)->findAll(),
        ]);
    }

    #[Route('/hr/role/create', name: 'app_hr_role_create', methods: ['POST'])]
    public function createRole(Request $request, EntityManagerInterface $em): Response
    {
        $role = new EmployeeRole();
        $role->code = (string) $request->request->get('code');
        $role->title = (string) $request->request->get('title');
        $role->defaultMonthlyWage = (string) $request->request->get('monthlyWage', '0');
        $role->defaultHourlyRate = (string) $request->request->get('hourlyRate', '0');
        $role->defaultBenefits = ['notes' => $request->request->get('benefits')];
        $em->persist($role);
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }

    #[Route('/hr/employee/create', name: 'app_hr_employee_create', methods: ['POST'])]
    public function createEmployee(Request $request, EntityManagerInterface $em): Response
    {
        $employee = new EmployeeRecord();
        $employee->name = (string) $request->request->get('name');
        $employee->email = $request->request->get('email') ?: null;
        $employee->countryCode = (string) $request->request->get('countryCode', 'NL');
        $employee->employmentType = (string) $request->request->get('employmentType', 'employee');
        $employee->monthlyWage = (string) $request->request->get('monthlyWage', '0');
        $employee->hourlyRate = (string) $request->request->get('hourlyRate', '0');
        $employee->taxCode = $request->request->get('taxCode') ?: null;
        $employee->benefits = [
            'pension' => $request->request->get('pension'),
            'travel_expenses' => $request->request->get('travelExpenses'),
            'holidays' => $request->request->get('holidays'),
        ];
        $em->persist($employee);
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }

    #[Route('/hr/benefit/create', name: 'app_hr_benefit_create', methods: ['POST'])]
    public function createBenefit(Request $request, EntityManagerInterface $em): Response
    {
        $benefit = new BenefitPolicy();
        $benefit->code = (string) $request->request->get('code');
        $benefit->label = (string) $request->request->get('label');
        $benefit->type = (string) $request->request->get('type', 'pension');
        $benefit->amount = (string) $request->request->get('amount', '0');
        $benefit->percent = (string) $request->request->get('percent', '0');
        $benefit->taxable = $request->request->getBoolean('taxable');
        $em->persist($benefit);
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }

    #[Route('/hr/time/clock-in', name: 'app_hr_clock_in', methods: ['POST'])]
    public function clockIn(Request $request, EntityManagerInterface $em): Response
    {
        $employee = $em->getRepository(EmployeeRecord::class)->find((int) $request->request->get('employeeId'));
        if (!$employee) { throw $this->createNotFoundException('Employee not found'); }
        $entry = new TimeClockEntry();
        $entry->employee = $employee;
        $entry->notes = $request->request->get('notes') ?: null;
        $em->persist($entry);
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }

    #[Route('/hr/time/{id}/clock-out', name: 'app_hr_clock_out')]
    public function clockOut(TimeClockEntry $entry, EntityManagerInterface $em): Response
    {
        $entry->clockOutAt = new \DateTimeImmutable();
        $seconds = $entry->clockOutAt->getTimestamp() - $entry->clockInAt->getTimestamp();
        $entry->hoursWorked = (string) round($seconds / 3600, 2);
        $entry->status = 'closed';
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }

    #[Route('/hr/project-time/create', name: 'app_hr_project_time_create', methods: ['POST'])]
    public function createProjectTime(Request $request, EntityManagerInterface $em): Response
    {
        $entry = new BillableTimeEntry();
        $entry->customerName = (string) $request->request->get('customerName');
        $entry->customerContract = $request->request->get('customerContract') ?: null;
        $entry->projectName = (string) $request->request->get('projectName');
        $entry->projectCode = (string) $request->request->get('projectCode');
        $entry->workDate = new \DateTimeImmutable((string) $request->request->get('workDate'));
        $entry->billableHours = (string) $request->request->get('billableHours', '0');
        $entry->companyHours = (string) $request->request->get('companyHours', '0');
        $entry->billingRate = (string) $request->request->get('billingRate', '0');
        $entry->taxRate = (string) $request->request->get('taxRate', '21');
        $em->persist($entry);
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }

    #[Route('/hr/vacancy/create', name: 'app_hr_vacancy_create', methods: ['POST'])]
    public function createVacancy(Request $request, EntityManagerInterface $em): Response
    {
        $vacancy = new Vacancy();
        $vacancy->title = (string) $request->request->get('title');
        $vacancy->roleCode = (string) $request->request->get('roleCode');
        $vacancy->wageOrRate = (string) $request->request->get('wageOrRate', '0');
        $vacancy->contractType = (string) $request->request->get('contractType', 'employee');
        $vacancy->hoursPerWeek = (string) $request->request->get('hoursPerWeek', '40');
        $vacancy->benefits = ['notes' => $request->request->get('benefits')];
        $vacancy->description = $request->request->get('description') ?: null;
        $em->persist($vacancy);
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }

    #[Route('/hr/onboarding/create', name: 'app_hr_onboarding_create', methods: ['POST'])]
    public function createOnboarding(Request $request, EntityManagerInterface $em): Response
    {
        $case = new OnboardingCase();
        $case->name = (string) $request->request->get('name');
        $case->roleTitle = (string) $request->request->get('roleTitle');
        $case->startDate = new \DateTimeImmutable((string) $request->request->get('startDate'));
        $case->assetsToIssue = array_map('trim', explode(',', (string) $request->request->get('assetsToIssue')));
        $case->tasks = array_map('trim', explode(',', (string) $request->request->get('tasks')));
        $em->persist($case);
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }

    #[Route('/hr/offboarding/create', name: 'app_hr_offboarding_create', methods: ['POST'])]
    public function createOffboarding(Request $request, EntityManagerInterface $em): Response
    {
        $case = new OffboardingCase();
        $case->name = (string) $request->request->get('name');
        $case->reason = (string) $request->request->get('reason');
        $case->compensation = (string) $request->request->get('compensation', '0');
        $case->assetsToRetrieve = array_map('trim', explode(',', (string) $request->request->get('assetsToRetrieve')));
        $case->tasks = array_map('trim', explode(',', (string) $request->request->get('tasks')));
        $em->persist($case);
        $em->flush();
        return $this->redirectToRoute('app_hr');
    }
}
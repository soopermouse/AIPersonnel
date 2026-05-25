<?php
namespace App\Controller;

use App\Entity\EmployeeRecord;
use App\Entity\Organization;
use App\Entity\TenantSubscription;
use App\Entity\WorkScheduleAssignment;
use App\Service\StaffPlanLimitService;
use App\Service\WorkforceSchedulerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SaasController extends AbstractController
{
    #[Route('/saas', name: 'app_saas_dashboard')]
    public function dashboard(EntityManagerInterface $em, StaffPlanLimitService $limits): Response
    {
        $organizations = $em->getRepository(Organization::class)->findAll();
        $subscriptions = $em->getRepository(TenantSubscription::class)->findAll();

        return $this->render('saas/dashboard.html.twig', [
            'organizations' => $organizations,
            'subscriptions' => $subscriptions,
            'limits' => $limits,
        ]);
    }

    #[Route('/saas/subscription/create', name: 'app_saas_subscription_create', methods: ['POST'])]
    public function createSubscription(Request $request, EntityManagerInterface $em): Response
    {
        $organization = $em->getRepository(Organization::class)->find((int) $request->request->get('organizationId'));

        if (!$organization) {
            throw $this->createNotFoundException('Organization not found.');
        }

        $subscription = new TenantSubscription();
        $subscription->organization = $organization;
        $subscription->plan = (string) $request->request->get('plan', TenantSubscription::PLAN_BASIC);
        $subscription->status = (string) $request->request->get('status', 'trial');

        $em->persist($subscription);
        $em->flush();

        return $this->redirectToRoute('app_saas_dashboard');
    }

    #[Route('/scheduler', name: 'app_scheduler')]
    public function scheduler(EntityManagerInterface $em): Response
    {
        return $this->render('scheduler/index.html.twig', [
            'employees' => $em->getRepository(EmployeeRecord::class)->findAll(),
            'assignments' => $em->getRepository(WorkScheduleAssignment::class)->findBy([], ['startsAt' => 'ASC']),
        ]);
    }

    #[Route('/scheduler/assignment/create', name: 'app_scheduler_assignment_create', methods: ['POST'])]
    public function createAssignment(
        Request $request,
        EntityManagerInterface $em,
        WorkforceSchedulerService $scheduler
    ): Response {
        $employee = $em->getRepository(EmployeeRecord::class)->find((int) $request->request->get('employeeId'));

        if (!$employee) {
            throw $this->createNotFoundException('Employee not found.');
        }

        $startsAt = new \DateTimeImmutable((string) $request->request->get('startsAt'));
        $endsAt = new \DateTimeImmutable((string) $request->request->get('endsAt'));

        if ($scheduler->hasOverlap($employee, $startsAt, $endsAt)) {
            $this->addFlash('error', 'This employee already has a schedule assignment during that time.');
            return $this->redirectToRoute('app_scheduler');
        }

        $assignment = new WorkScheduleAssignment();
        $assignment->organization = $employee->organization;
        $assignment->employee = $employee;
        $assignment->title = (string) $request->request->get('title');
        $assignment->startsAt = $startsAt;
        $assignment->endsAt = $endsAt;
        $assignment->workType = (string) $request->request->get('workType', 'company_time');
        $assignment->customerName = $request->request->get('customerName') ?: null;
        $assignment->projectCode = $request->request->get('projectCode') ?: null;
        $assignment->billableRate = $request->request->get('billableRate') ?: null;

        $em->persist($assignment);
        $em->flush();

        return $this->redirectToRoute('app_scheduler');
    }
}
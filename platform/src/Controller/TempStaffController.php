<?php
namespace App\Controller;

use App\Entity\AgencyPartner;
use App\Entity\Candidate;
use App\Entity\EmployeeRecord;
use App\Entity\InterviewProcess;
use App\Entity\Organization;
use App\Entity\TeamEvaluation;
use App\Entity\TempStaffAssignment;
use App\Service\RecruitmentWorkflowService;
use App\Service\TempStaffCostingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TempStaffController extends AbstractController
{
    #[Route('/temp-staff', name: 'app_temp_staff')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('temp_staff/index.html.twig', [
            'agencies' => $em->getRepository(AgencyPartner::class)->findAll(),
            'assignments' => $em->getRepository(TempStaffAssignment::class)->findBy([], ['createdAt' => 'DESC']),
            'employees' => $em->getRepository(EmployeeRecord::class)->findAll(),
        ]);
    }

    #[Route('/temp-staff/agencies/create', name: 'app_agency_create', methods: ['POST'])]
    public function createAgency(Request $request, EntityManagerInterface $em): Response
    {
        $organization = $em->getRepository(Organization::class)->find((int) $request->request->get('organizationId')) 
            ?? $em->getRepository(Organization::class)->findOneBy([]);

        $agency = new AgencyPartner();
        $agency->organization = $organization;
        $agency->name = (string) $request->request->get('name');
        $agency->contactName = $request->request->get('contactName') ?: null;
        $agency->contactEmail = $request->request->get('contactEmail') ?: null;
        $agency->status = (string) $request->request->get('status', 'preferred');
        $agency->defaultMarkupPercent = $request->request->get('defaultMarkupPercent') ?: null;

        $em->persist($agency);
        $em->flush();

        return $this->redirectToRoute('app_temp_staff');
    }

    #[Route('/temp-staff/assignments/create', name: 'app_temp_assignment_create', methods: ['POST'])]
    public function createAssignment(Request $request, EntityManagerInterface $em): Response
    {
        $worker = $em->getRepository(EmployeeRecord::class)->find((int) $request->request->get('workerId'));
        $agency = $request->request->get('agencyId')
            ? $em->getRepository(AgencyPartner::class)->find((int) $request->request->get('agencyId'))
            : null;

        if (!$worker) {
            throw $this->createNotFoundException('Worker not found.');
        }

        $assignment = new TempStaffAssignment();
        $assignment->organization = $worker->organization;
        $assignment->worker = $worker;
        $assignment->agency = $agency;
        $assignment->assignmentTitle = (string) $request->request->get('assignmentTitle');
        $assignment->projectCode = $request->request->get('projectCode') ?: null;
        $assignment->customerName = $request->request->get('customerName') ?: null;
        $assignment->hourlyPayRate = (string) $request->request->get('hourlyPayRate', '0.00');
        $assignment->billableClientRate = $request->request->get('billableClientRate') ?: null;
        $assignment->startsAt = new \DateTimeImmutable((string) $request->request->get('startsAt'));
        $assignment->endsAt = $request->request->get('endsAt') ? new \DateTimeImmutable((string) $request->request->get('endsAt')) : null;

        $em->persist($assignment);
        $em->flush();

        return $this->redirectToRoute('app_temp_staff');
    }

    #[Route('/recruitment', name: 'app_recruitment')]
    public function recruitment(EntityManagerInterface $em): Response
    {
        return $this->render('recruitment/index.html.twig', [
            'candidates' => $em->getRepository(Candidate::class)->findBy([], ['createdAt' => 'DESC']),
            'agencies' => $em->getRepository(AgencyPartner::class)->findAll(),
            'interviews' => $em->getRepository(InterviewProcess::class)->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/recruitment/candidates/create', name: 'app_candidate_create', methods: ['POST'])]
    public function createCandidate(Request $request, EntityManagerInterface $em): Response
    {
        $organization = $em->getRepository(Organization::class)->find((int) $request->request->get('organizationId'))
            ?? $em->getRepository(Organization::class)->findOneBy([]);

        $agency = $request->request->get('agencyId')
            ? $em->getRepository(AgencyPartner::class)->find((int) $request->request->get('agencyId'))
            : null;

        $candidate = new Candidate();
        $candidate->organization = $organization;
        $candidate->fullName = (string) $request->request->get('fullName');
        $candidate->email = (string) $request->request->get('email');
        $candidate->source = (string) $request->request->get('source', 'direct');
        $candidate->agency = $agency;
        $candidate->roleAppliedFor = $request->request->get('roleAppliedFor') ?: null;
        $candidate->skills = array_filter(array_map('trim', explode(',', (string) $request->request->get('skills', ''))));
        $candidate->notes = $request->request->get('notes') ?: null;

        $em->persist($candidate);
        $em->flush();

        return $this->redirectToRoute('app_recruitment');
    }

    #[Route('/recruitment/interviews/create', name: 'app_interview_create', methods: ['POST'])]
    public function createInterview(Request $request, EntityManagerInterface $em): Response
    {
        $candidate = $em->getRepository(Candidate::class)->find((int) $request->request->get('candidateId'));
        if (!$candidate) {
            throw $this->createNotFoundException('Candidate not found.');
        }

        $interview = new InterviewProcess();
        $interview->candidate = $candidate;
        $interview->stage = (string) $request->request->get('stage', 'screening');
        $interview->scheduledAt = $request->request->get('scheduledAt') ? new \DateTimeImmutable((string) $request->request->get('scheduledAt')) : null;
        $interview->interviewerName = $request->request->get('interviewerName') ?: null;
        $interview->teamLeadName = $request->request->get('teamLeadName') ?: null;
        $interview->feedback = $request->request->get('feedback') ?: null;
        $interview->score = $request->request->get('score') ? (int) $request->request->get('score') : null;
        $interview->decision = (string) $request->request->get('decision', 'pending');

        $em->persist($interview);
        $em->flush();

        return $this->redirectToRoute('app_recruitment');
    }

    #[Route('/team/evaluations', name: 'app_team_evaluations')]
    public function teamEvaluations(EntityManagerInterface $em): Response
    {
        return $this->render('team/evaluations.html.twig', [
            'employees' => $em->getRepository(EmployeeRecord::class)->findAll(),
            'evaluations' => $em->getRepository(TeamEvaluation::class)->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/team/evaluations/create', name: 'app_team_evaluation_create', methods: ['POST'])]
    public function createEvaluation(Request $request, EntityManagerInterface $em): Response
    {
        $employee = $em->getRepository(EmployeeRecord::class)->find((int) $request->request->get('employeeId'));
        if (!$employee) {
            throw $this->createNotFoundException('Employee not found.');
        }

        $evaluation = new TeamEvaluation();
        $evaluation->employee = $employee;
        $evaluation->teamLeadName = (string) $request->request->get('teamLeadName');
        $evaluation->teamName = $request->request->get('teamName') ?: null;
        $evaluation->performanceScore = (int) $request->request->get('performanceScore', 5);
        $evaluation->reliabilityScore = (int) $request->request->get('reliabilityScore', 5);
        $evaluation->teamFitScore = (int) $request->request->get('teamFitScore', 5);
        $evaluation->approvalRecommendation = (string) $request->request->get('approvalRecommendation', 'continue');
        $evaluation->comments = $request->request->get('comments') ?: null;

        $em->persist($evaluation);
        $em->flush();

        return $this->redirectToRoute('app_team_evaluations');
    }
}
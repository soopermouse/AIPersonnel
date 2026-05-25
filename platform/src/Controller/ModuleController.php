<?php

namespace App\Controller;

use App\Entity\ModuleDefinition;
use App\Entity\ModuleJob;
use App\Message\RunModuleJobMessage;
use App\Service\ModuleRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class ModuleController extends AbstractController
{
    #[Route('/modules', name: 'app_modules')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('modules/index.html.twig', [
            'modules' => $em->getRepository(ModuleDefinition::class)->findAll(),
            'jobs' => $em->getRepository(ModuleJob::class)->findBy([], ['createdAt' => 'DESC'], 20),
        ]);
    }

    #[Route('/modules/install-defaults', name: 'app_modules_install_defaults')]
    public function installDefaults(EntityManagerInterface $em, ModuleRegistry $registry): Response
    {
        foreach ($registry->defaultModules() as $code => $data) {
            $existing = $em->getRepository(ModuleDefinition::class)->findOneBy(['code' => $code]);
            if ($existing) {
                continue;
            }

            $module = new ModuleDefinition();
            $module->code = $code;
            $module->name = $data['name'];
            $module->description = $data['description'];
            $module->workerRoute = $data['worker_route'];
            $module->capabilities = $data['capabilities'];
            $module->available = true;
            $em->persist($module);
        }

        $em->flush();

        $this->addFlash('success', 'Default modules installed.');
        return $this->redirectToRoute('app_modules');
    }

    #[Route('/modules/run-job', name: 'app_modules_run_job', methods: ['POST'])]
    public function runJob(Request $request, EntityManagerInterface $em, MessageBusInterface $bus): Response
    {
        $job = new ModuleJob();
        $job->moduleCode = (string) $request->request->get('moduleCode');
        $job->jobType = (string) $request->request->get('jobType', 'healthcheck');
        $payloadRaw = $request->request->get('payload') ?: '{}';
        $job->payload = json_decode($payloadRaw, true) ?: [];

        $em->persist($job);
        $em->flush();

        $bus->dispatch(new RunModuleJobMessage($job->id));

        $this->addFlash('success', 'Module job queued.');
        return $this->redirectToRoute('app_modules');
    }
}
<?php

namespace App\MessageHandler;

use App\Entity\ModuleDefinition;
use App\Entity\ModuleJob;
use App\Message\RunModuleJobMessage;
use App\Service\WorkerGatewayClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RunModuleJobMessageHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private WorkerGatewayClient $worker,
    ) {}

    public function __invoke(RunModuleJobMessage $message): void
    {
        $job = $this->em->getRepository(ModuleJob::class)->find($message->moduleJobId);
        if (!$job) {
            return;
        }

        $module = $this->em->getRepository(ModuleDefinition::class)->findOneBy(['code' => $job->moduleCode]);
        if (!$module) {
            $job->status = 'failed';
            $job->errorMessage = 'Module definition not found.';
            $this->em->flush();
            return;
        }

        try {
            $job->status = 'running';
            $this->em->flush();

            $result = $this->worker->call($module->workerRoute, [
                'job_type' => $job->jobType,
                'payload' => $job->payload,
            ]);

            $job->result = $result;
            $job->status = 'completed';
            $job->completedAt = new \DateTimeImmutable();
        } catch (\Throwable $e) {
            $job->status = 'failed';
            $job->errorMessage = $e->getMessage();
        }

        $this->em->flush();
    }
}
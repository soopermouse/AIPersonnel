<?php
namespace App\Service;

use App\Entity\Candidate;

class RecruitmentWorkflowService
{
    public function nextStage(string $currentStage, string $decision): string
    {
        if ($decision === 'reject') {
            return 'rejected';
        }

        return match ($currentStage) {
            'screening' => 'team_interview',
            'team_interview' => 'approval',
            'approval' => 'approved',
            default => $currentStage,
        };
    }

    public function canConvertToWorker(Candidate $candidate): bool
    {
        return in_array($candidate->status, ['approved', 'offer_accepted'], true);
    }
}
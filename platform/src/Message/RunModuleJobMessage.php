<?php

namespace App\Message;

final class RunModuleJobMessage
{
    public function __construct(public readonly int $moduleJobId) {}
}
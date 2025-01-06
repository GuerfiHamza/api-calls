<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Agent;
use App\Services\OpenAIService;

class GenerateAgentMessages extends Command
{
    protected $signature = 'generate:agent-messages';
    protected $description = 'Generate AI messages for all agents periodically.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(OpenAIService $openAIService)
    {
        $agents = Agent::with('log')->get(); // Fetch agents and their logs

        foreach ($agents as $agent) {
            $log = $agent->log;

            if ($log) {
                // Generate a message for the agent's log
                $openAIService->generateMessage($log);
            } else {
                $this->warn("Agent '{$agent->name}' does not have a log.");
            }
        }

        $this->info('AI messages generated successfully.');
    }
}
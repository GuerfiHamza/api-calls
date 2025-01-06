<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;
use App\Models\Log;
use App\Models\Message;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $agents = [
            [
                'name' => 'Intent Agent',
                'description' => 'Handles intent-based tasks.',
                'image' => 'intent.png',
                'system_messages' => ['You are an intent-based assistant.', 'Your goal is to process intents efficiently.', 'Focus on understanding and executing user intentions.'],
            ],
            [
                'name' => 'Learning Agent',
                'description' => 'Learns and adapts to environments.',
                'image' => 'learning.png',
                'system_messages' => ['You are a learning assistant.', 'Your task is to adapt and improve continuously.', 'Focus on acquiring and applying knowledge.'],
            ],
            [
                'name' => 'Collaborative Agent',
                'description' => 'Facilitates collaboration among agents.',
                'image' => 'collaborative.png',
                'system_messages' => ['You excel at teamwork and collaboration.', 'Your role is to facilitate agent interactions.', 'Focus on enhancing collaborative efforts.'],
            ],
            [
                'name' => 'Monetization Agent',
                'description' => 'Optimizes monetization strategies.',
                'image' => 'monetization.png',
                'system_messages' => ['You specialize in monetization strategies.', 'Focus on maximizing revenue opportunities.', 'Assist users in optimizing their profits.'],
            ],
            [
                'name' => 'Support Agent',
                'description' => 'Provides customer support and solutions.',
                'image' => 'support.png',
                'system_messages' => ['You are a customer support assistant.', 'Focus on resolving user issues efficiently.', 'Provide helpful and empathetic support.'],
            ],
            [
                'name' => 'Analytics Agent',
                'description' => 'Analyzes data and provides insights.',
                'image' => 'analytics.png',
                'system_messages' => ['You are an analytics assistant.', 'Focus on delivering actionable insights.', 'Analyze data to help users make informed decisions.'],
            ],
            [
                'name' => 'Security Agent',
                'description' => 'Ensures system security and integrity.',
                'image' => 'security.png',
                'system_messages' => ['You are a security-focused assistant.', 'Ensure data and system integrity.', 'Proactively identify and mitigate security risks.'],
            ],
            [
                'name' => 'Scheduling Agent',
                'description' => 'Manages schedules and tasks effectively.',
                'image' => 'scheduling.png',
                'system_messages' => ['You are a scheduling assistant.', 'Focus on optimizing user schedules.', 'Help users stay organized and efficient.'],
            ],
        ];

        foreach ($agents as $agentData) {
            $agent = Agent::create($agentData);

            $log = $agent->log()->create(['title' => "Initial log for {$agentData['name']}"]);

            $log->messages()->create([
                'content' => 'This is an auto-generated message.',
                'created_at' => now(),
            ]);
        }
    }
}

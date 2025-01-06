<?php
namespace App\Services;

use OpenAI;
use App\Models\Log;
use App\Events\MessageCreated;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    public function generateMessage(Log $log)
    {
        $agent = $log->agent;

        // Select a random system message
        $systemMessages = $agent->system_messages;
        $systemMessage = $systemMessages[array_rand($systemMessages)];

        // Generate AI response
        $response = $this->client->chat()->create([
            'model' => 'gpt-4o-mini', // Or 'gpt-4'
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemMessage,
                ],
            ],
        ]);

        $aiMessage = $response['choices'][0]['message']['content'];

        // Save the message to the log
        $message = $log->messages()->create([
            'content' => trim($aiMessage),
            'created_at' => now(),
        ]);

        // Broadcast the event
        broadcast(new MessageCreated($message));

        return $aiMessage;
    }
}
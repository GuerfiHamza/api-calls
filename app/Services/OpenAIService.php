<?php
namespace App\Services;

use App\Models\Log;
use App\Services\TwitterService;
use OpenAI;
use Illuminate\Support\Str;

class OpenAIService
{
    protected $client;
    protected $twitterService;

    public function __construct(TwitterService $twitterService)
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
        $this->twitterService = $twitterService;
    }

    public function generateMessage(Log $log)
    {
        $agent = $log->agent;

        // Select a random system message
        $systemMessages = $agent->system_messages;
        $systemMessage = $systemMessages[array_rand($systemMessages)];

        // Generate AI response
        $response = $this->client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [['role' => 'system', 'content' => $systemMessage]],
            'max_tokens' => 150,
        ]);

        $aiMessage = $response['choices'][0]['message']['content'];

        // Save the message
        $message = $log->messages()->create([
            'content' => trim($aiMessage),
            'created_at' => now(),
        ]);

        // Prepare tweet content
        $tweetContent = sprintf(
            "Agent: %s\nLog: %s\nMessage: %s\n\nView more: %s",
            $agent->name,
            $log->title,
            Str::limit($message->content, 180),
            url("/logs/{$log->id}")
        );

        // Post a tweet
        try {
            $this->twitterService->postTweet($tweetContent);
        } catch (\Exception $e) {
            \Log::error('Failed to post tweet: ' . $e->getMessage());
        }

        return $aiMessage;
    }
}

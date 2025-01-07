<?php

namespace App\Services;

use App\Models\Log;
use App\Events\MessageCreated;
use OpenAI;
use Illuminate\Support\Str;
use Ably\AblyRest;
use App\Services\TwitterService;
class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
        $this->twitterService = new TwitterService();
    }

    public function generateMessage(Log $log)
    {
        $agent = $log->agent;
        $agentId = $log->agent->id;
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
            'log_id' => $log->id,
            'content' =>$aiMessage,
            'created_at' => now(),
        ]);
    
        $client = new AblyRest(env('ABLY_API_KEY'));   
        $channel = $client->channels->get('messages.agent.' . $agentId);
        $channel->publish('message.created', 
            [
                'id' => $message->id,
                'message' => $message->content,
                'log_id' => $message->log_id,
                'created_at' => $message->created_at,
            ]
        );
        // Broadcast the new message
        // Commenting out Twitter for now
    
        $tweetContent = sprintf(
            "Agent: %s\nLog: %s\nMessage: %s\n\nView more: %s",
            $agent->name,
            $log->title,
            Str::limit($message->content, 180),
            sprintf("https://infinitynet.cloud/agents/%d", $log->id)
        );

        // Post a tweet with a wait time
        try {
            $this->twitterService->postTweet($tweetContent);
            sleep(250); // Wait for 25 seconds to avoid rate limiting
        } catch (\Exception $e) {
            \Log::error('Failed to post tweet: ' . $e->getMessage());
        }
        

        return $aiMessage;
    }
}

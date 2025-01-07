<?php

namespace App\Services;

use Atymic\Twitter\Facade\Twitter;
use Atymic\Twitter\Contract\Http\Client;

class TwitterService
{
    public function postTweet(string $message)
    {
        try {
            $querier = Twitter::forApiV2()->getQuerier();

            $result = $querier->post(
                'tweets',
                [
                    Client::KEY_REQUEST_FORMAT => Client::REQUEST_FORMAT_JSON,
                    'text' => $message,
                ]
            );

            \Log::info('Tweet posted successfully: ' . json_encode($result));

            return $result;
        } catch (\Exception $e) {
            \Log::error('Failed to post tweet: ' . $e->getMessage());
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
}

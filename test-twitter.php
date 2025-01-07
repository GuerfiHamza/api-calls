<?php
require 'vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$twitter = new TwitterOAuth(
    getenv('TWITTER_API_KEY'),
    getenv('TWITTER_API_SECRET_KEY'),
    getenv('TWITTER_ACCESS_TOKEN'),
    getenv('TWITTER_ACCESS_TOKEN_SECRET')
);

try {
    $response = $twitter->post("statuses/update", ["status" => "Test tweet from standalone script"]);
    print_r($response);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
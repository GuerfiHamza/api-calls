<?php

use Illuminate\Support\Facades\Route;
use App\Models\Agent;
use App\Services\OpenAIService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/test-generate-message/{agentId}', function ($agentId, OpenAIService $openAIService) {
    $agent = Agent::findOrFail($agentId); // Get the agent by ID
    $log = $agent->log; // Get the agent's log

    if ($log) {
        $message = $openAIService->generateMessage($log); // Generate the message
        return response()->json(['message' => $message, 'status' => 'success']);
    }

    return response()->json(['status' => 'error', 'message' => 'No log found for this agent.']);
});
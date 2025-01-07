<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    // Fetch all agents with basic details
    public function index()
    {
        $agents = Agent::all(['id', 'name', 'description', 'image']);
        return response()->json($agents);
    }

    // Fetch messages for a specific agent
    public function messages(Agent $agent)
    {
        $log = $agent->log; // Fetch the agent's log

        if (!$log) {
            return response()->json(['error' => 'No log found for this agent.'], 404);
        }

        $messages = $log->messages()->orderBy('created_at', 'asc')->get(['id', 'content', 'created_at']);
        return response()->json([
            'agent' => [
            'id' => $agent->id,
            'name' => $agent->name, // Agent name
            'description' => $agent->description,
            'image' => $agent->image,
        ],
        'log' => [
            'id' => $log->id,
            'title' => $log->title, // Log title
        ],
        'messages' => $messages,
    ]);
    }
}
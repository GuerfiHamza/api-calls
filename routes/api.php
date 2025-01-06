<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;

Route::get('/agents', [AgentController::class, 'index']); // List all agents
Route::get('/agents/{agent}/messages', [AgentController::class, 'messages']); // List messages for a specific agent

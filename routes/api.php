<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AblyAuthController;
use App\Events\MessageCreated;
use App\Models\Message;

Route::get('/agents', [AgentController::class, 'index']); // List all agents
Route::get('/agents/{agent}/messages', [AgentController::class, 'messages']); // List messages for a specific agent
Route::get('/generate-token', [AblyAuthController::class, 'generateToken']);

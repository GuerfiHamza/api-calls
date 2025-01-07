<?php

use Illuminate\Support\Facades\Route;

use App\Models\Log;
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

Route::get('/test-openai', function (OpenAIService $openAIService) {
    $log = Log::find(1); // Replace with a valid log ID
    return $openAIService->generateMessage($log);
});
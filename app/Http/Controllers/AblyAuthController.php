<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AblyAuthController extends Controller
{
    public function generateToken(Request $request)
    {
        try {
            $clientId = $request->query('clientId', 'default-client');
            $ablyKey = config('services.ably.key');

            if (!$ablyKey) {
                return response()->json(['error' => 'Ably key is not configured'], 500);
            }

            $ably = new \Ably\AblyRest($ablyKey);

            $token = $ably->auth->createTokenRequest(['clientId' => $clientId]);

            return response()->json($token);
        } catch (\Exception $e) {
            \Log::error('Ably Auth Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate token'], 500);
        }
    }
}

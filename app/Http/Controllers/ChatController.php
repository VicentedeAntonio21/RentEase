<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
            'history' => ['nullable', 'array', 'max:10'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string'],
        ]);

        // Gemini calls the assistant role "model" instead of "assistant"
        $contents = collect($validated['history'] ?? [])
            ->map(fn($m) => [
                'role' => $m['role'] === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $m['content']]],
            ])
            ->push([
                'role' => 'user',
                'parts' => [['text' => $validated['message']]],
            ])
            ->values()
            ->all();

        $apiKey = config('services.gemini.api_key');

        $response = Http::post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key={$apiKey}",
            [
                'system_instruction' => [
                    'parts' => [['text' => $this->systemPrompt()]],
                ],
                'contents' => $contents,
                'generationConfig' => [
                    'maxOutputTokens' => 300,
                ],
            ]
        );

        if ($response->failed()) {
            \Illuminate\Support\Facades\Log::error('Gemini API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'reply' => "Sorry, I'm having trouble responding right now. Please try again in a moment.",
            ], 200);
        }

        $reply = $response->json('candidates.0.content.parts.0.text', "Sorry, I couldn't generate a response.");

        return response()->json(['reply' => $reply]);
    }

    private function systemPrompt(): string
    {
        return <<<PROMPT
        You are the support assistant for RentEase, an online rental property management and reservation platform.

        RentEase lets:
        - Tenants browse available rental units, filter by city/price/bedrooms, and submit rental applications online.
        - Property owners list properties and units, upload photos, set prices, and approve or reject tenant applications.
        - Admins oversee all users, properties, and applications platform-wide.

        Answer questions about how to use RentEase, how renting/listing works on the platform, and general rental advice. Keep answers short (2-4 sentences), friendly, and helpful. If asked something unrelated to RentEase or renting, politely redirect back to what you can help with. Do not make up specific prices, addresses, or account details you don't have access to — direct the user to browse listings or contact support for account-specific issues.
        PROMPT;
    }
}
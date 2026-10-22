<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class CodeCompilerService
{
    public function run(
        string $language,
        string $code,
        string $stdin = '',

    ): array {
        $apiKey = config('services.onecompiler.key');
        $apiUrl = config('services.onecompiler.url');

        if (!$apiKey || !$apiUrl) {
            return [
                'success' => false,
                'message' => 'OneCompiler API is not configured.',
            ];
        }

        $language = strtolower($language);

        $filename = match ($language) {
            'python' => 'main.py',
            'java' => 'Main.java',
            'mysql' => 'main.sql',
            'html' => 'index.html',
            'c'         => 'main.c',
            'cpp'       => 'main.cpp',
            'javascript' => 'main.js',
            default => $language,
        };

        if (!$filename) {
            return [
                'success' => false,
                'message' => 'Unsupported compiler language.',
            ];
        }

        try {
            $response = Http::withHeaders([
                'X-API-Key' => $apiKey,
            ])
                ->acceptJson()
                ->timeout(60)
                ->post($apiUrl, [
                    'language' => $language,
                    'stdin' => $stdin,
                    'files' => [
                        [
                            'name' => $filename,
                            'content' => $code,
                        ],
                    ],
                ]);

            if ($response->failed()) {
                return [
                    'success' => false,
                    'message' => 'OneCompiler API request failed.',
                    'status_code' => $response->status(),
                ];
            }

            return [
                'success' => true,
                'result' => $response->json(),
            ];
        } catch (ConnectionException $e) {
            return [
                'success' => false,
                'message' => 'Compiler service is unavailable or timed out.',
            ];
        }
    }
}

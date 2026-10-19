<?php

namespace App\Http\Controllers;

use App\Services\CodeCompilerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CodeCompilerController extends Controller
{
    protected CodeCompilerService $codeCompilerService;

    public function __construct(CodeCompilerService $codeCompilerService)
    {
        $this->codeCompilerService = $codeCompilerService;
    }

    public function run(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'language' => [
                'required',
                'string',
                Rule::in(['python', 'java', 'mysql' , 'html', 'javascript']),
            ],
            'code' => 'required|string|max:100000',
            'stdin' => 'nullable|string|max:50000',
        ]);

        $result = $this->codeCompilerService->run(
            $validated['language'],
            $validated['code'],
            $validated['stdin'] ?? ''
        );

        return response()->json(
            $result,
            $result['success'] ? 200 : 502
        );
    }
}

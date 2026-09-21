<?php

namespace App\Http\Controllers;

use App\Http\Requests\Content\StoreContentRequest;
use App\Http\Requests\Content\UpdateContentRequest;
use App\Services\ContentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct(private ContentService $contentService)
    {
    }

    public function index(Request $request): View
    {
        $contents = $this->contentService->paginate(10, $request->search);

        return view('pages.admin.contents.index', [
            'contents' => $contents,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $content = $this->contentService->find($id);

        return response()->json([
            'content' => $content,
        ], 200);
    }

    public function getAll(): JsonResponse
    {
        $contents = $this->contentService->all();

        return response()->json([
            'contents' => $contents,
        ], 200);
    }

    public function create(): View
    {
        return view('pages.admin.contents.create');
    }

    public function store(StoreContentRequest $request): RedirectResponse
    {
        $this->contentService->create($request->validated());

        return redirect()->back()->with('success', 'Content created successfully.');
    }

    public function edit(int $id): View
    {
        $content = $this->contentService->find($id);

        return view('pages.admin.contents.edit', [
            'content' => $content
        ]);
    }

    public function update(UpdateContentRequest $request, int $id): RedirectResponse
    {
        $this->contentService->update($id, $request->validated());

        return redirect()->back()->with('success', 'Content updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->contentService->delete($id);

        return redirect()->back()->with('success', 'Content deleted successfully.');
    }
}

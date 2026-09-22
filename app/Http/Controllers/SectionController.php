<?php

namespace App\Http\Controllers;

use App\Http\Requests\Section\StoreSectionRequest;
use App\Http\Requests\Section\UpdateSectionRequest;
use App\Http\Resources\SectionResource;
use App\Services\ClassesService;
use App\Services\SectionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __construct(private SectionService $sectionService, private ClassesService $classService)
    {
    }

    public function index(Request $request): View
    {
        $sections = $this->sectionService->paginate(10, $request->search);

        return view('pages.admin.sections.index', [
            'sections' => $sections,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $section = $this->sectionService->find($id);

        return response()->json([
            'section' => $section,
        ], 200);
    }

    public function getAll(): JsonResponse
    {
        $sections = $this->sectionService->all();

        return response()->json([
            'sections' => $sections,
        ], 200);
    }

    public function create(): View
    {
        $classes = $this->classService->all();
        return view('pages.admin.sections.create', [
            'classes' => $classes,
        ]);
    }

    public function store(StoreSectionRequest $request): RedirectResponse
    {
        $this->sectionService->create($request->validated());

        return redirect()->back()->with('success', 'Section created successfully.');
    }

    public function edit(int $id): View
    {
        $classes = $this->classService->all();
        $section = $this->sectionService->find($id);

        return view('pages.admin.sections.edit', [
            'section' => $section,
            'classes' => $classes,
        ]);
    }

    public function update(UpdateSectionRequest $request, int $id): RedirectResponse
    {
        $this->sectionService->update($id, $request->validated());

        return redirect()->back()->with('success', 'Section updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->sectionService->delete($id);

        return redirect()->back()->with('success', 'Section deleted successfully.');
    }

    // API methods
    public function apiIndex(int $id)
    {
        $sections = $this->sectionService->getSectionsByClass($id);

        return SectionResource::collection($sections);
    }
}
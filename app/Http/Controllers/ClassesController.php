<?php

namespace App\Http\Controllers;

use App\Http\Requests\Classes\StoreClassesRequest;
use App\Http\Requests\Classes\UpdateClassesRequest;
use App\Http\Resources\ClassResource;
use App\Services\ClassesService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function __construct(private ClassesService $classesService)
    {
    }

    public function index(Request $request): View
    {
        $classes = $this->classesService->paginate(10, $request->search);

        return view('pages.admin.classes.index', [
            'classes' => $classes,
        ]);
    }

    public function create(): View
    {
        return view('pages.admin.classes.create');
    }

    public function store(StoreClassesRequest $request): RedirectResponse
    {
        $this->classesService->create($request->validated());

        return redirect()->back()->with('success', 'Class created successfully.');
    }

    public function edit(int $id): View
    {
        $class = $this->classesService->find($id);

        return view('pages.admin.classes.edit', [
            'class' => $class
        ]);
    }

    public function update(UpdateClassesRequest $request, int $id): RedirectResponse
    {
        $this->classesService->update($id, $request->validated());

        return redirect()->back()->with('success', 'Class updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->classesService->delete($id);

        return redirect()->back()->with('success', 'Class deleted successfully.');
    }

    // API methods

    public function apiIndex()
    {
        $classes = $this->classesService->all();

        return ClassResource::collection($classes);
    }
}

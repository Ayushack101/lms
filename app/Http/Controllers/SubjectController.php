<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subject\StoreSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Services\BoardService;
use App\Services\SubjectService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(private SubjectService $subjectService, private BoardService $boardService)
    {
    }

    public function index(Request $request): View
    {
        $subjects = $this->subjectService->paginate(10, $request->search);

        return view('pages.admin.subjects.index', [
            'subjects' => $subjects,
        ]);
    }
    public function create(): View
    {
        $boards = $this->boardService->all();
        return view('pages.admin.subjects.create', [
            'boards' => $boards,
        ]);
    }

    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        $this->subjectService->create($request->validated());

        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    public function edit(int $id): View
    {
        $boards = $this->boardService->all();
        $subject = $this->subjectService->find($id);

        return view('pages.admin.subjects.edit', [
            'subject' => $subject,
            'boards' => $boards,
        ]);
    }

    public function update(UpdateSubjectRequest $request, int $id): RedirectResponse
    {
        $this->subjectService->update($id, $request->validated());

        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->subjectService->delete($id);

        return redirect()->back()->with('success', 'Subject deleted successfully.');
    }

    // API Methods

    public function apiIndex($board_id)
    {
        $subjects = $this->subjectService->getSubjectsByBoard($board_id);

        return SubjectResource::collection($subjects);
    }

}

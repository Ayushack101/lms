<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teacher\StoreTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Services\BoardService;
use App\Services\BookService;
use App\Services\ClassesService;
use App\Services\SubjectService;
use App\Services\TeacherService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TeacherController extends Controller
{
    public function __construct(private TeacherService $teacherService, private BoardService $boardService, private SubjectService $subjectService, private BookService $bookService, private ClassesService $classesService)
    {
    }

    public function index(): View
    {
        $teacher = $this->teacherService->paginate();

        return view('pages.admin.teachers.index', [
            'teachers' => $teacher
        ]);
    }

    public function store(StoreTeacherRequest $request)
    {
        $teacher = $this->teacherService->create($request->validated());

        return new TeacherResource($teacher);
    }

    public function edit(int $id): View
    {
        $teacher = $this->teacherService->find($id);
        $boards = $this->boardService->all();

        // Subjects by borard id
        $subjects = $this->subjectService->getSubjectsByBoard($teacher->board_id);

        // prepare old selected data
        $subjectBooks = $this->teacherService->subjectBooks($teacher->id);

        $books = $this->bookService->all();
        $classes = $this->classesService->all();

        return view('pages.admin.teachers.edit', [
            'teacher' => $teacher,
            'boards' => $boards,
            'subjects' => $subjects,
            'books' => $books,
            'subjectBooks' => $subjectBooks,
            'classes' => $classes,
        ]);
    }

    public function update(UpdateTeacherRequest $request, int $id): RedirectResponse
    {
        $this->teacherService->update($id, $request->validated());

        return redirect()->route("teachers.index")->with('success', 'Teacher updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->teacherService->delete($id);
        return redirect()->back()->with('success', 'Teacher deleted successfully.');
    }

    // API Methods
    public function apiIndex()
    {
        $teachers = $this->teacherService->all();

        return TeacherResource::collection($teachers);
    }

    public function apiShow(int $id)
    {
        $teacher = $this->teacherService->find($id);

        return new TeacherResource($teacher);
    }
}
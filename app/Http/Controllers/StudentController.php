<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Services\ClassesService;
use App\Services\SectionService;
use App\Services\StudentService;
use App\Services\TeacherService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class StudentController extends Controller
{
    public function __construct(private StudentService $studentService, private TeacherService $teacherService, private ClassesService $classesService, private SectionService $sectionService)
    {
    }

    public function index()
    {
        $student = $this->studentService->paginate();

        return view('pages.admin.students.index', [
            'students' => $student
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = $this->studentService->create($request->validated());

        return new StudentResource($student);
    }

    public function edit(int $id): View
    {
        $student = $this->studentService->find($id);
        $teachers = $this->teacherService->all();
        $classes = $this->classesService->all();
        $sectionSelectedClass = $this->sectionService->getSectionsByClass($student->class_id);

        return view('pages.admin.students.edit', [
            'student' => $student,
            'teachers' => $teachers,
            'classes' => $classes,
            'sections' => $sectionSelectedClass
        ]);
    }

    public function getSectionsByClass(int $id): JsonResponse
    {
        $sections = $this->sectionService->getSectionsByClass($id);

        return response()->json([
            'sections' => $sections,
        ], 200);
    }

    public function update(UpdateStudentRequest $request, int $id)
    {
        $this->studentService->update($id, $request->validated());

        return redirect()->back()->with('success', 'Student updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->studentService->delete($id);

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    // API Methods
    public function apiIndex()
    {
        $students = $this->studentService->all();

        return StudentResource::collection($students);
    }

    public function apiShow(int $id)
    {
        $student = $this->studentService->find($id);

        return new StudentResource($student);
    }
}

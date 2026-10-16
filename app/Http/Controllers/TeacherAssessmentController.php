<?php

namespace App\Http\Controllers;

use App\Services\TeacherAssessmentService;
use App\Services\TeacherCourseService;
use App\Http\Requests\TeacherAssessments\storeRequest;
use App\Http\Requests\TeacherAssessments\updateRequest;
use Illuminate\Http\Request;


class TeacherAssessmentController extends Controller
{
    public function __construct(private TeacherAssessmentService $teacherAssessmentService, private TeacherCourseService $teacherCourseService)
    {}

    public function subjects(int $teacherId)
    {
        return $this->teacherCourseService->getSubjectsByTeacher($teacherId);
    }

    public function books(int $subjectId, int $teacherId)
    {
        return $this->teacherAssessmentService->getBooksByTeacher($subjectId, $teacherId);
    }

    public function class(int $bookId)
    {
        return $this->teacherAssessmentService->getClassByBookId($bookId);
    }

    public function tests(int $bookId)
    {
        return $this->teacherAssessmentService->getTestsByBook($bookId);
    }

    public function AssignAssessment(storeRequest $request)
    {
        return $this->teacherAssessmentService->teacherAssignAssessment($request->validated());
    }

    public function getAssignedAssessments(int $teacherId)
    {
        return $this->teacherAssessmentService->getAssessmentByTeacher($teacherId);
    }

    // public function editAssignedAssessment(updateRequest $request, $assessmentId)
    // {
    //     return $this->teacherAssessmentService->editAssessment($request->validated(), $assessmentId);
    // }
    public function editAssignedAssessment(updateRequest $request, int $assessmentId)
{
    return $this->teacherAssessmentService->editAssessment(
        $assessmentId,
        $request->validated()
    );
}

    public function deleteAssignedAssessment(int $assessmentId)
    {
        return $this->teacherAssessmentService->deleteAssessment($assessmentId);
    }
public function getSubmittedWork(int $teacehrId,  int $bookId, int  $sectionId){
    return $this->teacherAssessmentService->getSubmitedWork($teacehrId, $bookId, $sectionId);
}
public function teacherClass( int $teacher_id){
    return $this->teacherAssessmentService->getteacherClassByTeacher($teacher_id);
}

    public function editSubmittedWork( int $assessmentId,  int $studentId, Request $request)
    {
        return $this->teacherAssessmentService->editSubmittedWork($assessmentId, $studentId, $request->all());

    }

}

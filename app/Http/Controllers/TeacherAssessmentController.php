<?php

namespace App\Http\Controllers;

use App\Services\TeacherAssessmentService;
use App\Services\TeacherCourseService;
use App\Http\Requests\TeacherAssessments\storeRequest;
use App\Http\Requests\TeacherAssessments\updateRequest;

class TeacherAssessmentController extends Controller
{
    public function __construct(private TeacherAssessmentService $teacherAssessmentService, private TeacherCourseService $teacherCourseService)
    {}

    public function subjects($teacherId)
    {
        return $this->teacherCourseService->getSubjectsByTeacher($teacherId);
    }

    public function books($subjectId, $teacherId)
    {
        return $this->teacherAssessmentService->getBooksByTeacher($subjectId, $teacherId);
    }

    public function class($bookId)
    {
        return $this->teacherAssessmentService->getClassByBookId($bookId);
    }

    public function tests( $bookId)
    {
        return $this->teacherAssessmentService->getTestsByBook($bookId);
    }

    public function AssignAssessment(storeRequest $request)
    {
        return $this->teacherAssessmentService->teacherAssignAssessment($request->validated());
    }

    public function getAssignedAssessments($teacherId)
    {
        return $this->teacherAssessmentService->getAssessmentByTeacher($teacherId);
    }

    public function editAssignedAssessment(updateRequest $request, $assessmentId)
    {
        return $this->teacherAssessmentService->editAssessment($request->validated(), $assessmentId);
    }

    public function deleteAssignedAssessment($assessmentId)
    {
        return $this->teacherAssessmentService->deleteAssessment($assessmentId);
    }
}

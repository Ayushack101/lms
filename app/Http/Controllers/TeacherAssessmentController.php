<?php

namespace App\Http\Controllers;

use App\Services\TeacherAssessmentService;
use App\Services\TeacherCourseService;
use Illuminate\Http\Request;
use App\Http\Requests\TeacherAssessments\storeRequest;
use App\Http\Requests\TeacherAssessments\updateRequest;

class TeacherAssessmentController extends Controller
{
    //
    public function __construct(private TeacherAssessmentService $teacherAssessmentService, private TeacherCourseService $teacherCourseService)
    {
        
    }

    public function subjects($teacherId)
    {
        return  $this->teacherCourseService->getSubjectsByTeacher($teacherId);

    }

    /*  don't need 
     public function books($teacherId, $subjectId )
     {
         return  $this->teacherAssessmentService->getBooksByTeacher($teacherId, $subjectId);
     }
    */

    public function classes($subjectId, $teacherId)
    {
        return  $this->teacherAssessmentService->getClassByTeacher($subjectId, $teacherId);
    }
    
    public function testTypes( $bookId)
    {
        return  $this->teacherAssessmentService->getTestTypeByBook($bookId);
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
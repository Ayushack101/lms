<?php

namespace App\Http\Controllers;
use App\Services\TeacherCourseService;
use App\Services\TeacherAssignmentService;
use Illuminate\Http\Request;
use App\Http\Requests\TeacherAssignment\StoreAssignmentRequest;
use App\Http\Requests\TeacherAssignment\UpdateAssignmentRequest;

class TeacherAssignmentController extends Controller
{
    //
    public function __construct(private TeacherAssignmentService $teacherAssignmentService, private TeacherCourseService $teacherCourseService)
    {
    }

    public function subjects($teacherId)
    {
        return $this->teacherCourseService->getSubjectsByTeacher($teacherId);
    }

    public function books( $teacherId, $subjectId)
    {
        return $this->teacherAssignmentService->getBooksByTeacher( $teacherId, $subjectId);
    }

    public function class($bookId)
    {
        return $this->teacherAssignmentService->getClassByBookId($bookId);
    }
    public function getAssignedAssessments($teacherId){
        return $this->teacherAssignmentService->getAssignment($teacherId);
    }
    public function getAssignedQuestion($assignmentId){
        return $this->teacherAssignmentService->getAssignedQuestion($assignmentId);
    }

    public function assignAssignment(StoreAssignmentRequest $request)
    {
    return $this->teacherAssignmentService->createAssignment($request->validated());
    }
    public function editAssignedAssignment($id, UpdateAssignmentRequest $request ){
        return $this->teacherAssignmentService->editAssignment( $id,  $request->validated() );
    }
    public function deleteAssignment($id){
        return $this->teacherAssignmentService->deleteAssignment($id);
    }





}

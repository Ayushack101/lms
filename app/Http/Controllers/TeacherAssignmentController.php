<?php

namespace App\Http\Controllers;
use App\Services\TeacherCourseService;
use App\Services\TeacherAssignmentService;
use Illuminate\Http\Request;
use App\Http\Requests\TeacherAssignment\StoreAssignmentRequest;
use App\Http\Requests\TeacherAssignment\UpdateAssignmentRequest;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\ClassResource;
use App\Http\Resources\AssignmentResource;

class TeacherAssignmentController extends Controller
{
    //
    public function __construct(private TeacherAssignmentService $teacherAssignmentService, private TeacherCourseService $teacherCourseService)
    {
    }

    public function subjects($teacherId)
    {
        $subjects = $this->teacherCourseService->getSubjectsByTeacher($teacherId);
        return SubjectResource::collection($subjects);
    }

    public function books( $teacherId, $subjectId)
    {
       $books= $this->teacherAssignmentService->getBooksByTeacher($teacherId, $subjectId);
       return BookResource::collection($books);
    }

    public function class($bookId)
    {
        $class = $this->teacherAssignmentService->getClassByBookId($bookId);
        return ClassResource::collection($class);
    }

    public function getAssignedAssessments($teacherId){
        $asssignment =  $this->teacherAssignmentService->getAssignment($teacherId);
        return AssignmentResource::collection($asssignment);
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
    public function getSubmittedAssignments($teacherId, $bookId, $sectionId){
        return $this->teacherAssignmentService->getSubmittedAssignments($teacherId, $bookId, $sectionId);
    }
    public function storeTeacherfeedback( Request $request){
        return $this->teacherAssignmentService->storeTeacherfeedback($request->all());
    }


}

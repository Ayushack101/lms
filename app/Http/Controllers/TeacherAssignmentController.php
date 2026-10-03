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
use App\Http\Resources\AssignmentQuestionResource;

class TeacherAssignmentController extends Controller
{
    //
    public function __construct(private TeacherAssignmentService $teacherAssignmentService, private TeacherCourseService $teacherCourseService)
    {
    }

    public function subjects(int $teacherId)
    {
        $subjects = $this->teacherCourseService->getSubjectsByTeacher($teacherId);
        return SubjectResource::collection($subjects);
    }

    public function books(int $teacherId, int $subjectId)
    {
       $books= $this->teacherAssignmentService->getBooksByTeacher($teacherId, $subjectId);
       return BookResource::collection($books);
    }

    public function class(int $bookId)
    {
        $class = $this->teacherAssignmentService->getClassByBookId($bookId);
        return ClassResource::collection($class);
    }

    public function getAssignedAssessments(int $teacherId){
        $asssignment =  $this->teacherAssignmentService->getAssignment($teacherId);
        return AssignmentResource::collection($asssignment);
    }
    public function getAssignedQuestion(int $assignmentId){
        $questions = $this->teacherAssignmentService->getAssignedQuestion($assignmentId);
        return AssignmentQuestionResource::collection($questions);
    }

    public function assignAssignment(StoreAssignmentRequest $request)
    {
    return $this->teacherAssignmentService->createAssignment($request->validated());
    }
    public function editAssignedAssignment(int $id, UpdateAssignmentRequest $request ){
        return $this->teacherAssignmentService->editAssignment( $id,  $request->validated() );
    }
    public function deleteAssignment(int $id){
        return $this->teacherAssignmentService->deleteAssignment($id);
    }
    public function getSubmittedAssignments(int $teacherId, int $bookId, int $sectionId){
        return $this->teacherAssignmentService->getSubmittedAssignments($teacherId, $bookId, $sectionId);
    }
    public function storeTeacherfeedback(Request $request){
        return $this->teacherAssignmentService->storeTeacherfeedback($request->all());
    }


}

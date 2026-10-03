<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentAssignmentService;
use App\Http\Requests\StudentAssignment\StoreAssignmentRequest;
Use App\Http\Resources\AssignmentResource;
use App\Http\Resources\AssignmentQuestionResource;

class StudentAssignmentController extends Controller
{
    //
    public function __construct(private StudentAssignmentService $studentAssignmentService)
    {
    }

    public function getAssignedAssignment($teacherId, $classId, $sectionId){
        $assignment = $this->studentAssignmentService->getAssignedAssigment($teacherId, $classId, $sectionId);
        return AssignmentResource::collection($assignment);
    }
    public function getquestions($assignmentId){
        $questions = $this->studentAssignmentService->getquestionsByAssignmentId($assignmentId);
        return AssignmentQuestionResource::collection($questions);
    }
    public function attemptAssignment($assignmentId, $studentId,  StoreAssignmentRequest $request){
        $attempt = $this->studentAssignmentService->attemptAssignment($assignmentId, $studentId , $request->answers);
        return $attempt;
    }
}

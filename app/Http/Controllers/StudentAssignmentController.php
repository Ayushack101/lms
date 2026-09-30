<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentAssignmentService;
use App\Http\Requests\StudentAssignment\StoreAssignmentRequest;

class StudentAssignmentController extends Controller
{
    //
    public function __construct(private StudentAssignmentService $studentAssignmentService)
    {
    }

    public function getAssignedAssignment($teacherId, $bookId, $sectionId){
        $assignment = $this->studentAssignmentService->getAssignedAssigment($teacherId, $bookId, $sectionId);
        return $assignment;
    }
    public function getquestions($assignmentId){
        $questions = $this->studentAssignmentService->getquestionsByAssignmentId($assignmentId);
        return $questions;
    }
    public function attemptAssignment($assignmentId, $studentId,  StoreAssignmentRequest $request){
        $attempt = $this->studentAssignmentService->attemptAssignment($assignmentId, $studentId , $request->answers);
        return $attempt;
    }
}

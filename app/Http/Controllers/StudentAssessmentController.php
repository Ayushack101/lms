<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentAssessmentService;

class StudentAssessmentController extends Controller
{
public function __construct(private StudentAssessmentService $studentAssessmentService)
{
}


public function index($teacherId, $bookId, $sectionId)
{
    $assessments = $this->studentAssessmentService->getStudentAssessment($teacherId, $bookId, $sectionId);
    return $assessments;
}
public function  getquestions($assessmentId){
    $questions = $this->studentAssessmentService->getquestionsByAssessmentId($assessmentId);
    return $questions;
}
public function attemptAssessment( $assessmentId, $studentId, Request $request)
{
    // $answers = $request->input('answers');
    return $this->studentAssessmentService->attemptAssessment($assessmentId, $studentId, $request->answers);
}
public function getAnswerByAttemptId($attemptId)
{
    $answers = $this->studentAssessmentService->getAnswerByAttemptId($attemptId);
    return $answers;
}
}


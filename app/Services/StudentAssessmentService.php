<?php

namespace App\Services;
use App\Models\TestTemplate;
use App\Models\TestAssessment;
use App\Models\StudentTestAttempt;
use App\Models\StudentAnswer;
use Illuminate\Support\Facades\DB;

class StudentAssessmentService
{
   
    public function getStudentAssessment($TeacherId, $bookId, $sectionId)
    {
         $getStudentAssessment = TestAssessment::where('teacher_id', $TeacherId)->where('book_id', $bookId)
            ->where('section_id', $sectionId)->get();
         return $getStudentAssessment;
    }
    public function getquestionsByAssessmentId($assessmentId)
{
    $assessment = TestAssessment::where('id', $assessmentId)->first();
    $template = TestTemplate::where('id', $assessment->test_template_id)->first();
    return $template->questions()->get();


// $assessment = TestAssessment::where('id', $assessmentId)->first();
//    $templateId =  $assessment->test_template_id;
//    return TestTemplate::find($templateId)->questions()->get();
    
}


    public function attemptAssessment($assessmentId, $studentId, $answers)
    {

    $assessment = TestAssessment::where('id', $assessmentId)->first();
    $template = TestTemplate::where('id', $assessment->test_template_id)->first();
    $questions = $template->questions()->get();


    foreach ($answers as $answer) {
        $questionId = $answer['question_id'];
        $question = $questions->find($questionId);

        if (!$question) {
            return response()->json([
            'message' => 'Question ID does not belong to this assessment test template'
        ], 422);
        }
    }


    $totalMarks = $questions->sum('marks');
    

    $attempt = StudentTestAttempt::create([
        'student_id' => $studentId,
        'test_template_id' => $template->id,
        'total_marks' => $totalMarks,
        'obtained_marks' => 0,
    ]);

    $obtainedMarks = 0;
    foreach ($answers as $answer) {
        $questionId = $answer['question_id'];
        $question = $questions->find($questionId);
        $isCorrect = $answer['answer'] == $question->answer;

        $marks = $isCorrect ? $question->marks : 0;

        $obtainedMarks += $marks;

        StudentAnswer::create([
            'attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'answer' => $answer['answer'],
            'is_correct' => $isCorrect,
            'marks_obtained' => $marks,
        ]);
    }

    $attempt->update([
        'obtained_marks' => $obtainedMarks
    ]);

    return [
        'attempt_id' => $attempt->id,
        'total_marks' => $totalMarks,
        'obtained_marks' => $obtainedMarks
    ];
    }
      
    
    public function getAnswerByAttemptId($attemptId)
    {
    $answers = StudentAnswer::where('attempt_id', $attemptId)->get();
    return $answers;
    }
}



    
    

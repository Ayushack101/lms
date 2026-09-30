<?php

namespace App\Services;
use App\Models\TestTemplate;
use App\Models\TeacherAssessment;
use App\Models\StudentAssessmentAttempt;
use App\Models\StudentAssessmentAnswer;
use Illuminate\Support\Facades\DB;

class StudentAssessmentService
{

    public function getStudentAssessment($TeacherId, $class_id, $sectionId)
    {
         $getStudentAssessment = TeacherAssessment::where('teacher_id', $TeacherId)->where('class_id', $class_id)->where('section_id', $sectionId)->where('status', 'active')->with('studentAssessmentAttempts', 'testTemplate' , 'book')->get();

        return $getStudentAssessment;
    }
    public function getquestionsByAssessmentId($assessmentId)
{
    $assessment = TeacherAssessment::where('id', $assessmentId)->first();
    $template = TestTemplate::where('id', $assessment->test_template_id)->first();
    return $template->questions()->get();


// $assessment = TestAssessment::where('id', $assessmentId)->first();
//    $templateId =  $assessment->test_template_id;
//    return TestTemplate::find($templateId)->questions()->get();

}


   public function attemptAssessment($assessmentId, $studentId, $answers)
    {
        $assessment = TeacherAssessment::where('id', $assessmentId)->first();
        $template = TestTemplate::where( 'id',   $assessment->test_template_id )->first();
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

        $attempt = StudentAssessmentAttempt::create([
            'student_id' => $studentId,
            'test_template_id' => $template->id,
            'total_marks' => $totalMarks,
            'obtained_marks' => 0,
            'assessment_id' => $assessment->id,
            'is_submitted' => 'submitted'
        ]);

        $obtainedMarks = 0;

        foreach ($answers as $answer) {


            $questionId = $answer['question_id'];
            $question = $questions->find($questionId);
            if ($answer['answer'] === null) {
                $isCorrect = 0;
                $marks = 0;
            } else {
                $isCorrect = $answer['answer'] == $question->answer;
                $marks = $isCorrect ? $question->marks : 0;
            }

            $obtainedMarks += $marks;

            StudentAssessmentAnswer::create([
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
            'message' => 'Assessment submitted successfully',
        ];
    }


    public function getAnswerByAttemptId($attemptId)
    {
    $answers = StudentAssessmentAnswer::where('attempt_id', $attemptId)->with('question')->get();
    return $answers;
    }
}






<?php

namespace App\Services;
use App\Models\TeacherAssignment;
use App\Models\AssignmentQuestion;
use App\Models\StudentAssignmentAttempt;
use App\Models\StudentAssignmentAnswer;
use Illuminate\Support\Facades\DB;
class StudentAssignmentService
{
    /**
     * Create a new class instance.
     */
     public function getAssignedAssigment($teacherId, $bookId, $sectionId){
       $assignment = TeacherAssignment::where('teacher_id', $teacherId)->where('book_id', $bookId)->where('section_id', $sectionId)->get();
       return $assignment;
     }
     public function getquestionsByAssignmentId($assignmentId){
        $questions = AssignmentQuestion::where('assignment_id', $assignmentId)->get();
        return $questions;
     }
    public function attemptAssignment(int $assignmentId, int $studentId, array $answers)
    {
        try {
            DB::beginTransaction();

            // Check every question
            foreach ($answers as $answer) {

                if (empty($answer['answer'])) {
                    throw new \Exception('Answer cannot be empty');
                }

                $question = AssignmentQuestion::where('id', $answer['question_id'])->where('assignment_id', $assignmentId)->first();

                if (!$question) {
                    throw new \Exception('Question ID ' . $answer['question_id'] . ' does not belong to this assignment');
                }
            }

            // Create attempt
            $attempt = StudentAssignmentAttempt::create([
                'assignment_id' => $assignmentId,
                'student_id' => $studentId,
                'status' => 'submitted',
            ]);

            // Save answers
            foreach ($answers as $answer) {
                StudentAssignmentAnswer::create([
                    'student_assignment_attempt_id' => $attempt->id,
                    'question_id' => $answer['question_id'],
                    'answer' => $answer['answer'],
                ]);
            }

            DB::commit();

            return $attempt;

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    

}

<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\TestTemplate;
use App\Models\TestAssessment;
use App\Models\AssignmentQuestion;
use App\Models\TeacherAssignment;
use App\Models\StudentAssignmentAttempt;
use App\Models\StudentAssignmentAnswer;
use App\Models\TeacherAssignmentFeedback;

use Illuminate\Support\Facades\DB;
class TeacherAssignmentService
{

       public function getBooksByTeacher(int $teacher_id, int $subjectId )
    {
        $teacher = Teacher::where('id', $teacher_id)->first();
        $books = $teacher->books()->where('subject_id', $subjectId)->with('class')->orderBy('id', 'asc')->get();
        return $books;
    }

    public function getClassByBookId(int $bookId){
        $class = Book::where('id', $bookId)->first()->class()->get();
        return $class;
    }
    public function getAssignment(int $teacherId){
        $assignment = TeacherAssignment::where('teacher_id', $teacherId)->get();
        return $assignment;
    }
    public function getAssignedQuestion(int $assignmentId)
    {
        $question = AssignmentQuestion::where('assignment_id', $assignmentId)->get();
        return $question;
    }

    public function createAssignment(array $data)
    {
        try {
            DB::beginTransaction();
            $assignment = TeacherAssignment::create([
                'teacher_id' => $data['teacher_id'],
                'subject_id' => $data['subject_id'],
                'book_id' => $data['book_id'],
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'assignment_name' => $data['assignment_name'],
                'type' => $data['type'],
                'end_date' => $data['end_date'],
            ]);

            foreach ($data['questions'] as $question) {
                AssignmentQuestion::create([
                    'assignment_id' => $assignment->id,
                    'category' => $question['category'],
                    'question' => $question['question'],
                    'option_a' => $question['option_a'] ?? null,
                    'option_b' => $question['option_b'] ?? null,
                    'option_c' => $question['option_c'] ?? null,
                    'option_d' => $question['option_d'] ?? null
                ]);
            }

            DB::commit();
            return $assignment->load('assignmentQuestions');

        }
        catch (\Throwable $exception) {

            DB::rollBack();

            report($exception);

            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function editAssignment(int $assignmentId, array $data)
    {
        $assignment = TeacherAssignment::findOrFail($assignmentId);

        $assignment->update([
            'teacher_id' => $data['teacher_id'],
            'subject_id' => $data['subject_id'],
            'book_id' => $data['book_id'],
            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'assignment_name' => $data['assignment_name'],
            'type' => $data['type'],
            'end_date' => $data['end_date'],
        ]);
        // $assignment->update($data);


            $questions = AssignmentQuestion::where( 'assignment_id',  $assignmentId )->orderBy('id')->get();
            foreach ($data['questions'] as $index => $question) {

                if (isset($questions[$index])) {

                    $questions[$index]->update([
                        'category' => $question['category'],
                        'question' => $question['question'],
                        'option_a' => $question['option_a'] ?? null,
                        'option_b' => $question['option_b'] ?? null,
                        'option_c' => $question['option_c'] ?? null,
                        'option_d' => $question['option_d'] ?? null,
                    ]);
                }
            }


        return $assignment->load('assignmentQuestions');
    }

    public function deleteAssignment(int $assignmentId)
    {
        $assignment = TeacherAssignment::where('id', $assignmentId)->delete();
        return $assignment;
    }

    public function getSubmittedAssignments(int $assignmentId)
    {
        $attempts = StudentAssignmentAttempt::where('id', $assignmentId)->where('status', 'submitted')->first();
        $answers = StudentAssignmentAnswer::where('student_assignment_attempt_id', $attempts->id)->with('question')->get();
        return $answers;

    }
public function storeTeacherFeedback(array $data)
{
    $attemptId = $data['attempt_id'];
    $studentId = $data['student_id'];

    $attempt = StudentAssignmentAttempt::where(['id' => $attemptId,'student_id' => $studentId, 'status' => 'submitted'])->first();

    if (!$attempt) {
        return response()->json([
            'message' => 'Submitted attempt not found'
        ], 404);
    }

    foreach ($data['questions'] as $item) {

        TeacherAssignmentFeedback::create([
            'attempt_id' => $attemptId,
            'question_id' => $item['question_id'],
            'feedback' => $item['feedback']
        ]);
    }

    return response()->json([
        'message' => 'Feedback saved successfully'
    ]);
}

}

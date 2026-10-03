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


use Illuminate\Support\Facades\DB;
class TeacherAssignmentService
{

    public function getBooksByTeacher(int $teacher_id, int $subjectId)
    {
        $teacher = Teacher::find($teacher_id);
        $books = $teacher->books()->where('subject_id', $subjectId)->orderBy('id', 'asc')->get()->load('class');
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
                'book_id' => $data['book_id'],
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'assignment_name' => $data['assignment_name'],
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
            return response()->json([
                'message' => 'Assignment created successfully',
            ], 201);

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
            'book_id' => $data['book_id'],
            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'assignment_name' => $data['assignment_name'],
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


        return response()->json([
                'message' => 'Assignment updated successfully',
            ], 200);
    }

    public function deleteAssignment(int $assignmentId)
    {
        $assignment = TeacherAssignment::where('id', $assignmentId)->delete();
        return $assignment;
    }


    // Submitted Assignment

    public function getSubmittedAssignments(int $teacherId, int $bookId, int $sectionId)
    {
        $assignments = TeacherAssignment::where(['teacher_id' => $teacherId, 'book_id' => $bookId, 'section_id' => $sectionId])
            ->with([ 'book', 'attempts' => function ($query) {
                    $query->where('status', 'submitted')->with('answers.question', 'student');
                }])->get();

        return $assignments;
    }


    public function storeTeacherFeedback(array $data)
    {
        $attempt = StudentAssignmentAttempt::where([
            'id' => $data['attempt_id'],
            'student_id' => $data['student_id'],
            'status' => 'submitted'
        ])->first();

        if (!$attempt) {
            return response()->json([
                'message' => 'Submitted attempt not found'
            ], 404);
        }

        $attempt->update([
            'teacher_feedback' => $data['feedback']
        ]);

        return response()->json([
            'message' => 'Feedback saved successfully'
        ]);
    }

}

<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\TestTemplate;
use App\Models\TeacherAssessment;
use App\Models\StudentAssessmentAttempt;
use App\Models\StudentAssessmentAnswer;

class TeacherAssessmentService
{
    public function getBooksByTeacher(int $subjectId, int $teacher_id)
    {
        $teacher = Teacher::where('id', $teacher_id)->first();
        $books = $teacher->books()->where('subject_id', $subjectId)->with('class')->orderBy('id', 'asc')->get();

        return $books;
    }

    public function getClassByBookId(int $bookId){
        $class = book::where('id', $bookId)->first()->class()->pluck('class')->toArray();
        return $class;
    }

    public function getTestsByBook(int $book_id)
    {
        $book_id = Book::where('id', $book_id)->first();
        $tests = TestTemplate::where('book_id', $book_id->id)->with('questions')->get();
        return $tests;
    }

     //  Crud operations for teacher assessment
     public function teacherAssignAssessment(array $data)
    {
        $assessment = TeacherAssessment::where(['test_template_id' => $data['test_template_id'],'section_id' => $data['section_id'],
        ])->first();

        if ($assessment) {
            return response()->json([
                'message' => 'This test is already assigned to this section.'
            ], 422);
        }

        return TeacherAssessment::create($data);
    }

     public function getAssessmentByTeacher(int $teacher_id)
     {
        $assessments = TeacherAssessment::where('teacher_id', $teacher_id)->with('testTemplate.questions', 'class', 'book')->get();
        return $assessments;
     }

     public function editAssessment(int $id, array $data)
     {
         $assessment = TeacherAssessment::where('id', $id)->update($data);
         return $assessment;
     }
     public function deleteAssessment(int $id)
     {
         $assessment = TeacherAssessment::where('id', $id)->delete();
         return $assessment;
     }

     //  ** submitted work
    public function editSubmittedWork( int $assessmentId,  int $studentId, array $data)
    {
        $attempt = StudentAssessmentAttempt::where('assessment_id', $assessmentId)->where('student_id', $studentId)->first();

        if (!$attempt) {
            return response()->json([
                'message' => 'Assessment attempt not found'
            ], 404);
        }

        $template = TestTemplate::where('id', $attempt->test_template_id)->with('questions')->first();

        $questions = $template->questions;

        $obtainedMarks = 0;

        foreach ($data['answers'] as $answer) {

            $question = $questions->find($answer['question_id']);

            if (!$question) {
                return response()->json([
                    'message' => 'Question ID ' . $answer['question_id'] . ' does not belong to this assessment test template'
                ], 422);
            }

            $isCorrect = $answer['marks_obtained'] > 0;

            StudentAssessmentAnswer::where('attempt_id', $attempt->id)
                ->where('question_id', $answer['question_id'])
                ->update([
                    'marks_obtained' => $answer['marks_obtained'],
                    'is_correct' => $isCorrect
                ]);

            $obtainedMarks += $answer['marks_obtained'];
        }

        $attempt->update([
            'obtained_marks' => $obtainedMarks
            'is_teacher_checked'=> "checked"
        ]);

        return response()->json([
            'message' => 'Submitted work updated successfully'
        ]);
    }


}

<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\TestTemplate;
use App\Models\TestAssessment;

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
        $tests = TestTemplate::where('book_id', $book_id->id)->get();
        return $tests;
    }

     //  Crud operations for teacher assessment
     public function teacherAssignAssessment($data)
     {
         $assessment = TestAssessment::create($data);
         return $assessment;
     }

     public function getAssessmentByTeacher($teacher_id)
     {
        // $assessments = TestAssessment::where('teacher_id', $teacher_id)->with('testTemplate')->get();
        $assessments = TestAssessment::where('teacher_id', $teacher_id)->with('testTemplate.questions')->get();

        return $assessments;
     }

     public function editAssessment($id, $data)
     {
         $assessment = TestAssessment::where('id', $id)->update($data);
         return $assessment;
     }
     public function deleteAssessment($id)
     {
         $assessment = TestAssessment::where('id', $id)->delete();
         return $assessment;
     }
}

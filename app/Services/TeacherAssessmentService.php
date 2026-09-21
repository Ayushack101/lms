<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Teacher;
use App\Models\TestTemplate;
use App\Models\TestAssessment;

class TeacherAssessmentService
{
    /* We can use TeacherCourseService
     public function getSubjectsByTeacher(int $teacher_id)
     {
         $teacher = Teacher::where('id', $teacher_id)->first();
         $subjects = $teacher->subjects()->orderBy('id', 'asc')->get();
         return $subjects;

     public function getBooksByTeacher(int $teacher_id, int $subject_id)
     {
         $teacher = Teacher::where('id', $teacher_id)->first();
         $books = $teacher->books()->where('subject_id', $subject_id)->orderBy('id', 'asc')->get();
         return $books;
     }
    */

    public function getClassByTeacher(int $subjectId, int $teacher_id)
    {
        $teacher = Teacher::where('id', $teacher_id)->first();
        $classes = $teacher->books()->where('subject_id', $subjectId)->with('class')->orderBy('id', 'asc')->get()->pluck('class');

        return $classes;
    }

    public function getTestTypeByBook(int $book_id)
    {
        $book_id = Book::where('id', $book_id)->first();
        $testType = TestTemplate::where('book_id', $book_id->id)->get();
        return $testType;
    }



     //*  Crud operations for teacher assessment
     public function teacherAssignAssessment($data)
     {
         $assessment = TestAssessment::create($data);
         return $assessment;
     }

     public function getAssessmentByTeacher($teacher_id)
     {
         $assessments = TestAssessment::where('teacher_id', $teacher_id)->get();
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
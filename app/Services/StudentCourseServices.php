<?php

namespace App\Services;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\BookContentFile;
use App\Models\Board;

class StudentCourseServices
{
   public function getTeacherIdByStudent(int $studentId)
   {
      $TeacherId = Student::find($studentId)->teacher_id;
      return $TeacherId;
   }

   public function getBoardByTeacherID(int $teacher_id)
   {
      $teacher = Teacher::findOrFail($teacher_id);
      $boards = Board::where('id', $teacher->board_id)->get();
      return $boards;
   }

   public function getSubjectByTeacherID(int $teacher_id, int $board_id)
   {
      $teacher = Teacher::find($teacher_id);
      $subjects = $teacher->subjects()->where('board_id', $board_id)->get();
      return $subjects;
   }

   public function getclasskByStudentID(
      int $student_id,
      int $teacher_id
   ) {
      $student = Student::findOrFail($student_id);
      $teacher = Teacher::findOrFail($teacher_id);
      $class = $teacher->classes()->where('classes.id', $student->class_id)->get();
      return $class;
   }

   public function getcontentsByTeacherId( int $teacher_id, int $subject_id, int $class_id)
   {
      $teacher = Teacher::findOrFail($teacher_id);
      $book = $teacher->books()->where('books.class_id', $class_id)->where('books.subject_id', $subject_id)->firstOrFail();
      return $book->contents()->whereIn('allow', ['both', 'student'])->get();
   }

   public function getContentFilesByTeacherId(int $teacher_id, int $class_id, int $subject_id, int $content_id)
   {
      $teacher = Teacher::findOrFail($teacher_id);
      $book = $teacher->books()->where('books.class_id', $class_id)->where('books.subject_id', $subject_id)->firstOrFail();
      $content = $book->contents()->where('contents.id', $content_id)->firstOrFail();

      $files = BookContentFile::where('book_id', $book->id)->where('content_id', $content->id)->get();
      return $files;
   }
}

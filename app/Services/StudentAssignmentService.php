<?php

namespace App\Services;

class StudentAssignmentService
{
    /**
     * Create a new class instance.
     */
     public function getAssignedAssigment($teacherId, $bookId, $sectionId){
       $assignment = TeacherAssignment::where('teacher_id', $teacherId)->where('book_id', $bookId)
       ->where('section_id', $sectionId)->get();
     }
}

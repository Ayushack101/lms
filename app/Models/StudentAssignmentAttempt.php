<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssignmentAttempt extends Model
{
    //
    protected $table = 'student_assignment_attempts';
    protected $fillable = [
        'student_id',
        'assignment_id',
        'status',
        'teacher_feedback',
    ];

      public function student()
    {
        return $this->belongsTo(Student::class);
    }
     public function assignment()
    {
        return $this->belongsTo(TeacherAssignment::class, 'assignment_id');
    }
    public function answers()
    {
        return $this->hasMany(StudentAssignmentAnswer::class, 'attempt_id');
    }
}

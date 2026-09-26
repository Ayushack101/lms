<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssignmentAnswer extends Model
{
    //
    protected $table = 'student_assignment_answers';
    protected $fillable = [
        'student_assignment_attempt_id',
        'question_id',
        'answer',
    ];

      public function attempt()
    {
        return $this->belongsTo(StudentAssignmentAttempt::class, 'attempt_id' );
    }

    public function question()
    {
        return $this->belongsTo( AssignmentQuestion::class,  'question_id' );
    }
}

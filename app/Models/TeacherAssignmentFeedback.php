<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAssignmentFeedback extends Model
{
    //
    protected $fillable = [
        'attempt_id',
        'question_id',
        'feedback',
    ];


    public function attempt()
    {
        return $this->belongsTo(StudentAssignmentAttempt::class,  'attempt_id' );
    }
}

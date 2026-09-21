<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    //
     protected $fillable = [
        'attempt_id',
        'question_id',
        'answer',
        'is_correct',
        'marks_obtained'
    ];

    public function attempt()
    {
        return $this->belongsTo(StudentTestAttempt::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTestAttempt extends Model
{
    //
     protected $fillable = ['student_id', 'test_template_id', 'total_marks', 'obtained_marks'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class, 'attempt_id');
    }

    public function testTemplate()
    {
        return $this->belongsTo(TestTemplate::class);
    }
}

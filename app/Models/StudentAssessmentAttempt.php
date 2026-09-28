<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssessmentAttempt extends Model
{
    //
     protected $fillable = ['student_id', 'assessment_id', 'test_template_id', 'total_marks', 'obtained_marks', 'is_submitted'];

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
    public function assessment()
    {
        return $this->belongsTo(TeacherAssessment::class);
    }
}

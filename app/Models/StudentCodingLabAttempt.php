<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCodingLabAttempt extends Model
{
    protected $fillable = [
        'student_id',
        'coding_lab_id',
        'status',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function teacherCodingLab()
    {
        return $this->belongsTo(TeacherCodingLab::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentCodingLabAnswer::class, 'attempt_id');
    }
}

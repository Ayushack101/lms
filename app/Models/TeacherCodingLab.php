<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCodingLab extends Model
{
    protected $fillable =[
        'title',
        'langauge',
        'teacher_id',
        'book_id',
        'class_id',
        'section_id',
        'start_date',
        'end_date',
        'questions',
        'description',

    ];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function studentCodingLabAttempts()
    {
        return $this->hasMany(StudentCodingLabAttempt::class);
    }


}

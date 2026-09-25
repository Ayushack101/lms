<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAssignment extends Model
{
    //
    $table = 'teacher_assignments';
    protected $fillable = [
                'title',
                'teacher_id',
                'subject_id', 'book_id',
                 'class_id',
                 'section_id',
                 'type',
                 'due_date'
                ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function assignmentQuestions()
    {
        return $this->hasMany(AssignmentQuestion::class);
    }

}

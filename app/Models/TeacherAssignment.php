<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAssignment extends Model
{
    //
  protected   $table = 'teacher_assignments';
    protected $fillable = [
                'assignment_name',
                'teacher_id',
                'subject_id',
                'book_id',
                 'class_id',
                 'section_id',
                 'type',
                 'end_date'
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
        return $this->hasMany(AssignmentQuestion::class,  'assignment_id'  );
    }

}

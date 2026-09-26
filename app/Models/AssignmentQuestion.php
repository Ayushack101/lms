<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentQuestion extends Model
{
    //
   protected  $table = 'assignment_questions';
    protected $fillable = [
        'assignment_id',
        'category',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
    ];
     public function assignment()
    {
        return $this->belongsTo(TeacherAssignment::class);
    }

}

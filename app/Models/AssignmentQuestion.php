<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentQuestion extends Model
{
    //
    $table = 'assignment_questions';
    protected $fillable = [
        'assignment_id',
        'category',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'answer'
    ];
     public function assignment()
    {
        return $this->belongsTo(TeacherAssignment::class);
    }

}

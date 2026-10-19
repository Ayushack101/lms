<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCodingLabAnswer extends Model
{
    protected $fillable = [
        'attempt_id',
        'answer',
    ];

    public function attempt()
    {
        return $this->belongsTo(StudentCodingLabAttempt::class,  'attempt_id');
    }
    
}

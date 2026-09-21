<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'subject_name',
        'subject_code',
        'board_id',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subjects');
    }
}

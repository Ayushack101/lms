<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $fillable = [
        'teacher_name',
        'teacher_mobile',
        'school_name',
        'school_address',
        'personal_address',
        'principal_name',
        'dob',
        'session_start',
        'representative_name',
        'representative_contact',
        'teacher_code',
        'status',
        'user_id',
        'board_id',
        'class_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function board()
    {
        return $this->belongsTo(Board::class,'board_id' );
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'teacher_books');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'teacher_classes', 'teacher_id', 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}

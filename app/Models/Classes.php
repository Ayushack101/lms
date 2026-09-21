<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'class_name',
        'class_position',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_classes');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_name',
        'subject_id',
        'class_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class, 'book_content');
    }

    public function bookContentFiles()
    {
        return $this->hasMany(BookContentFile::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_books');
    }
}

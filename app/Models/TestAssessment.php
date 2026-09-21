<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAssessment extends Model
{
    protected $fillable = [
        'teacher_id',
        'test_template_id',
        'class_id',
        'section_id',
        'book_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function testTemplate()
    {
        return $this->belongsTo(TestTemplate::class);
    }
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

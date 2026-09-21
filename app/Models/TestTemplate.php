<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestTemplate extends Model
{
    //

    protected $table = 'test_templates';
    
    protected $fillable = [
        'test_name',
        'type',
        'description',
        'status',
        'book_id',
        'class_id',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
    
}

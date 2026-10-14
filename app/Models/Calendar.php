<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    //
    protected $table = 'calendars';
    protected $fillable = [
        'title',
        'description',
        'teacher_id',
        'book_id',
        'class_id',
        'section_id',
        'date',
        'start_time',
        'status',
        'type'
    ];

     public function teacher(){
        return $this->belongsTo(Teacher::class);
     }
     public function book(){
        return $this->belongsTo(Book::class);
     }
     public function class(){
        return $this->belongsTo(Classes::class);
    }
      public function section(){
        return $this->belongsTo(Section::class);
    }


}

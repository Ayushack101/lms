<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = [
        'test_template_id',
        'question',
        'a',
        'b',
        'c',
        'd',
        'answer',
        'marks'
    ];

    public function testTemplate()
    {
        return $this->belongsTo(TestTemplate::class);
    }
}

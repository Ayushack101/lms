<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'content_name',
        'allow'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_content');
    }

    public function bookContentFiles()
    {
        return $this->hasMany(BookContentFile::class);
    }
}

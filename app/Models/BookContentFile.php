<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookContentFile extends Model
{
    protected $fillable = [
        'title',
        'file_type',
        'file_path',
        'extract_path',
        'entry_file',
        'file_url',
        'description',
        'thumbnail',
        'book_id',
        'content_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}

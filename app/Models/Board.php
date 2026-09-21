<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['board_name'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}

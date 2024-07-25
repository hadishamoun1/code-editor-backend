<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public function users()
    {
        $this->belongsToMany(User::class);
    }

    public function user()
    {
        $this->belongsToMany(User::class);
    }
}

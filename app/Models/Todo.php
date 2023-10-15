<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['header', 'description', 'deadline', 'completed', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

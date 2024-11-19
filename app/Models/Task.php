<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['task', 'completed', 'user_id'];

    // The relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

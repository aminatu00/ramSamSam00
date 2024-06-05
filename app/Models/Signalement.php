<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'user_id', 'content_type', 'message'];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

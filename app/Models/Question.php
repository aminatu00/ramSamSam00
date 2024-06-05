<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category_id',
        'likes',
        'media_path', // Ajoutez ceci si vous souhaitez attribuer le champ category_id en masse
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }
}

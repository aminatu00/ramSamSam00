<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'sondage_id', 'option_voted']; // Ajoutez 'option_voted' si ce n'est pas déjà le cas

    public function sondage()
    {
        return $this->belongsTo(Sondage::class);
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

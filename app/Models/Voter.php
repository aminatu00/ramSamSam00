<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable = ['user_id', 'sondage_id', 'option_voted','vote_count']; // Ajoutez 'option_voted' si ce n'est pas déjà le cas

    // Relation avec le sondage
    public function sondage()
    {
        return $this->belongsTo(Sondage::class);
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec l'option
    // public function option()
    // {
    //     return $this->belongsTo(Option::class);
    // }
}

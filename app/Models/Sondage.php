<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sondage extends Model
{
    use HasFactory;


    
    protected $fillable = [
        'user_id', // Ajoute user_id ici
        'subject',
        'question',
        'options',
        'expiry_date',
        'mentor_id', // Ajout de mentor_id ici
    ];
    

    // public function sondageOptions()
    // {
    //     return $this->hasMany(Option::class);
    // }

    public function votes()
    {
        return $this->hasMany(Voter::class);
    }
    public function vote()
    {
        return $this->hasMany(Vote::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentorat()
    {
        return $this->belongsTo(Mentorat::class, 'mentor_id');
    }

 

    public function creator()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

}

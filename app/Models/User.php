<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'niveau', 'user_type', 'interests', 'expertise', 'sub_expertises',
    ];


    public function publishedSondages()
    {
        return $this->hasMany(Sondage::class, 'mentor_id');
    }

    public function answeredSondages()
    {
        return $this->belongsToMany(Sondage::class, 'reponse_sondages', 'user_id', 'sondage_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function sondages()
    {
        return $this->hasMany(Sondage::class);
    }

    public function Signalement()
    {
        return $this->hasMany(Signalement::class);
    }


    public function createdMentorats()
    {
        return $this->hasMany(Mentorat::class, 'mentor_id');
    }
    public function mentorats()
    {
        return $this->hasMany(Mentorat::class, 'mentor_id');
    }
    /**
     * Get the mentorats received by the student.
     */
    public function receivedMentorats()
    {
        return $this->hasMany(Mentorat::class, 'student_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

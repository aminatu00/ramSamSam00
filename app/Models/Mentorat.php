<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentorat extends Model
{
    protected $fillable = ['date', 'time', 'meeting_link', 'subject', 'mentor_id','domaine','sondage_id','session_type'];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }


    public function sondage()
    {
        return $this->belongsTo(Sondage::class, 'id_sondage');
    }
}

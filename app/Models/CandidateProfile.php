<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'profile_photo',
        'email',
        'phone',
        'skills',
        'experience',
        'education',
        'resume',
        'portfolio',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
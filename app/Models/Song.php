<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'story',
        'user_id',
        'main_audio_link',
        'preview_link',
        'lyrics',
        'producer_name',
        'duration',
        'number_of_verses',
        'original_instrumental',
        'has_sample',
        'is_explicit'
    ];

    public function writers() 
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

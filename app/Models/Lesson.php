<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $fillable = ['course_id', 'title', 'content', 'status', 'position'];
    
    protected $casts = [
        'status' => 'string',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'lesson_user')->withTimestamps();
    }

    // Alias for completedLessons relationship
    public function users()
    {
        return $this->belongsToMany(User::class, 'lesson_user')->withTimestamps();
    }
}

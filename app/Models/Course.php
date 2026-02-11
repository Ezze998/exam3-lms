<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // teacher
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }

    // students
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }
}

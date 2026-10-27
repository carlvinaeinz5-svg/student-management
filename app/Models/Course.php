<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'title',
        'lecturer_id'
    ];

   public function lecturer()
{
    return $this->belongsTo(User::class, 'lecturer_id');
}

public function students()
{
    return $this->belongsToMany(User::class, 'registrations', 'course_id', 'student_id');
}
}
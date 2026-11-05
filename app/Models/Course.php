<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'title',
        'lecturer_id',
    ];

    // A course has one lecturer assigned to teach it.
    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    // A course can have many students registered for it.
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'registrations',
            'course_id',
            'student_id'
        )->withTimestamps();
    }
}

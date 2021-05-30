<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'exams_students');
    }

    public function student()
    {
        return $this->student_id;
    }

    public function examResult()
    {
        return $this->hasOne(ExamResults::class);
    }

}

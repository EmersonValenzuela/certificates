<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey = 'id_student';
    protected $fillable = ['course_id', 'code_student', 'course_student', 'name_student', 'score_student'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id_course');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $primaryKey = 'id_course';
    protected $fillable = ['name_course', 'templateOne', 'tempalteTwo', 'dateFinish'];

    public function students()
    {
        return $this->hasMany(Student::class, 'course_id', 'id_course');
    }
}

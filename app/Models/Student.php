<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'first_name',
        'surname',
        'student_num',
        'birth_date',
        'address',
        'parent_phone_number',
        'second_phone_number',
        'gender',
        'classroom_id',
        'enrollment_date',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'subject', 'birth_date', 'email', 'phone_number', 'gender'];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'level',
        'academic_year',
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'student_class_id');
    }
}
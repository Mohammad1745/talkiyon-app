<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'student_info';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'date_of_birth', 'introduction', 'about'];
}

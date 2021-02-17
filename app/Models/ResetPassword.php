<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'reset_password';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'code'];
}

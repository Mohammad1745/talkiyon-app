<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseBoo extends Model
{
    use HasFactory;

    protected $fillable = ['response_id', 'user_id'];
}
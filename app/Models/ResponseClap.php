<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseClap extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'response_clap';

    /**
     * @var string[]
     */
    protected $fillable = ['response_id', 'user_id'];
}

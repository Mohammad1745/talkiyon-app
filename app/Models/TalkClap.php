<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkClap extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'talk_clap';

    /**
     * @var string[]
     */
    protected $fillable = ['talk_id', 'user_id'];
}

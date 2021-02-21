<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkResponse extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'talk_response';

    /**
     * @var string[]
     */
    protected $fillable = [
        'talk_id', 'user_id', 'parent_id', 'content'
    ];
}

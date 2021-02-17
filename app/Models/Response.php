<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'response';

    /**
     * @var string[]
     */
    protected $fillable = ['talk_id', 'user_id', 'parent_id', 'content'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'talk';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'content', 'parent_id', 'type', 'security_type'];
}

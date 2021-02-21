<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'connection';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'connected_with', 'type', 'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseFile extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'response_file';

    /**
     * @var string[]
     */
    protected $fillable = ['response_id', 'file'];
}

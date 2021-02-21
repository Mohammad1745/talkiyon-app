<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkResponseFile extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'talk_response_file';

    /**
     * @var string[]
     */
    protected $fillable = [
        'response_id', 'file'
    ];
}

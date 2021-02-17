<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkFile extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'talk_file';

    /**
     * @var string[]
     */
    protected $fillable = ['talk_id', 'file'];
}

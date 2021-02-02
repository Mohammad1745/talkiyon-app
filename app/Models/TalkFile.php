<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkFile extends Model
{
    use HasFactory;

    protected $fillable = ['talk_id', 'file'];
}
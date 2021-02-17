<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'address';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'country', 'division', 'district', 'sub_district', 'zipcode', 'location'];
}

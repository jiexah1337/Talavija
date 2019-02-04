<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    public $timestamps = false;
    protected $fillable = [
        'country',
        'city',
        'address',
        'notes',
    ];
}

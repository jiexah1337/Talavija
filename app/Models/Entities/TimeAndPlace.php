<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class TimeAndPlace extends Model
{
    protected $table = 'time_and_places';
    public $timestamps = false;
    protected $fillable = [
        'date',
        'location_id',
    ];

    protected $dates = [
        'date'
    ];

    public function location(){
        return $this->hasOne(Location::class,'id','location_id');
    }

    public function date(){
        if(isset($this->date)){
            return $this->date->format('d/m/Y');
        } else {
            return null;
        }
    }
}

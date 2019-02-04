<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    protected $table = 'residences';
    public $timestamps = false;
    protected $fillable = [
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];


    public function location(){
        return $this->hasOne(Location::class,'id', 'location_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function span(){
        $interval = $this->start_date->CarbonInterval::weeks($this->end_date);
        return $interval;
    }

    public function start_date(){
        if(isset($this->start_date)){
            return $this->start_date->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function end_date(){
        if(isset($this->end_date)){
            return $this->end_date->format('d/m/Y');
        } else {
            return null;
        }
    }
}

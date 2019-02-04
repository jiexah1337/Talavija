<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    protected $table = 'studies';
    public $timestamps = false;
    //

    protected $dates = [
        'start_date',
        'end_date',
    ];


    protected $fillable = [
        'name',
        'faculty',
        'program',
        'degree',

        'graduated',
        'start_date',
        'end_date',
    ];

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

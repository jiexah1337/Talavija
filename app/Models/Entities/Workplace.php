<?php

namespace Entities;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    protected $table = 'workplaces';
    public $timestamps = false;

    protected $fillable = [
        'start_date',
        'end_date',
        'field',
        'company',
        'position',
    ];

    protected $dates = [
        'start_date',
        'end_date'
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

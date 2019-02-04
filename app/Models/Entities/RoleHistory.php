<?php

namespace Entities;

use Carbon\Carbon;
use Sentinel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

class RoleHistory extends Model
{
    protected $table = 'role_history';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'member_id',
        'role_id',
        'start_date',
        'expire_date',
        'report'
    ];

    protected $dates = [
        'start_date',
        'expire_date'
    ];

    public function span()
    {
        $interval = $this->start_date->CarbonInterval::weeks($this->expire_date);
        return $interval;
    }

    public function start_date()
    {
        if (isset($this->start_date)) {
            return $this->start_date->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function expire_date()
    {
        if (isset($this->expire_date)) {
            return $this->expire_date->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function roleNamme()
    {
        return Sentinel::findById($this->role_id)->get();
    }

    public function user() {
        return $this->belongsTo(User::class,'member_id', 'member_id');
    }
}

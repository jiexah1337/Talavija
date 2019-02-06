<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Repatriation extends Model
{
    protected $table = 'repatriations';
    public $timestamps = false;
    protected $fillable = [
        'year',
        'month',
        'amount',
        'title',
        'type',
        'member_id',
        'discount',
        'issue_date',
        'paid_date',
        'total_balance'
    ];

    protected $dates = [
        'issue_date',
        'paid_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'member_id', 'member_id');
    }

    public function issue_date(){
        if(isset($this->issue_date) && $this->issue_date !== null){
            return $this->issue_date->format('d/m/Y');
        } else {
            return null;
        }
    }
    public function set(int $value){
        $this->total_balance=$value;
    }
    public function paid_date(){
        if(isset($this->paid_date) && $this->paid_date !== null){
            return $this->paid_date->format('d/m/Y');
        } else {
            return null;
        }
    }
}
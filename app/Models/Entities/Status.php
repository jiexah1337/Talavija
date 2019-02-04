<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    protected $table = 'statuses';

    protected $fillable = [
        'title',
        'abbreviation',
        'default',
        'status_id'
    ];

    protected $guarded = [
        'id'
    ];

    public function users(){
        $pivot = DB::table('user_statuses')->where('status_id',$this->id);
        $users = User::where(function ($q) use ($pivot){
            foreach($pivot as $p){
                $q->orWhere('member_id', $pivot->member_id);
            }
        });
        return $users;
    }
}

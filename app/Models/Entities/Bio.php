<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    protected $table = 'bios';

    protected $fillable = [
        'member_id',
        'olderman_id',
        'col_father_id',
        'col_mother_id',
        'birthdata_id',
        'deathdata_id',
        'father',
        'mother',
        'children',
        'notes',
        'bio',
        'otherfamily'
    ];

    public function user(){
        return $this->belongsTo(User::class,'member_id','member_id');
    }

    public function birthdata(){
        return $this->hasOne(TimeAndPlace::Class, 'id','birthdata_id');
    }

    public function deathdata(){
        return $this->hasOne(TimeAndPlace::Class, 'id','deathdata_id');
    }

    public function colmother(){
        return $this->hasOne(User::Class, 'member_id','col_mother_id');
    }

    public function colfather(){
        return $this->hasOne(User::Class, 'member_id','col_father_id');
    }

    public function olderman(){
        return $this->hasOne(User::Class,'member_id','olderman_id');
    }
}

<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'content',
        'type',
        'post_date',
        'title',
    ];

    protected $dates = [
        'post_date',
    ];

    public function user() {
        return $this->belongsTo(User::class,'member_id', 'member_id');
    }

}

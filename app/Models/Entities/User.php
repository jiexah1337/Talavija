<?php

namespace Entities;

use Illuminate\Notifications\Notifiable;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Support\Facades\DB;
use Entities\Status as Status;
use Carbon\Carbon;
class User extends SentinelUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'surname',
        'permissions',
        'member_id',
        'phone',
        'start_date',
        'spk_date',
        'fil_date',
    ];

    protected $dates = [
        'start_date',
        'spk_date',
        'fil_date',
    ];

    protected $loginNames = ['username','email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function bio(){
        return $this->hasOne(Bio::class, 'member_id','member_id');
    }

    public function workplaces(){
        return $this->hasMany(Workplace::class, 'member_id','member_id');
    }

    public function studies(){
        return $this->hasMany(Study::class, 'member_id','member_id');
    }

    public function residences(){
        return $this->hasMany(Residence::class, 'member_id','member_id')->orderByDesc('start_date');
    }

    public function lastResidenceAlt(){
        return $this->residences()->first();
    }

    public function lastResidence(){
        if($this->residences()->first() !== null){
            return $this->residences()->first();
        }
        else return null;
    }

    public function repatriations(){
        return $this->hasMany(Repatriation::class, 'member_id', 'member_id');
    }

    public function isalive(){
        $mirus=DB::table('bios')->where('member_id',$this->member_id)->value('deathdata_id');
        if(null == TimeAndPlace::query()->where('id',$mirus)->value('date')){
            return true;
        }else{
            return false;
        }

        }
    public function status(){
        $statuses = DB::table('user_statuses')->where('member_id',$this->member_id)->get();
        $statusDefs = DB::table('statuses')->get();
        $today = Carbon::now();
        $currentSemester = 0;
        if($today->month <= 6){
            $currentSemester = 1;
        } else {
            $currentSemester = 2;
        }
        $status = $statuses->where('year', $today->year)->where('semester', $currentSemester)->sortByDesc('created_at')->first() or null;
        if($status == null){
            $status = $this->createDefaultStatus($this->member_id, $currentSemester);
        } else {
            $status = $statusDefs->where('id',$status->status_id)->first();
        }

        return $status;
    }

    public function statuses(){
        $statuses = DB::table('user_statuses')->where('member_id',$this->member_id)->orderBy('semester')->orderBy('year')->get();
        $statusDefs = Status::get();
//        dd([$statuses, $statusDefs]);
        $output = [];
        foreach($statuses as $key=>$status){
            $statusDef = $statusDefs->where('id',$status->status_id)->first();
            if (isset($statusDef)){
                $entry = [
                    'year'  =>  $status->year,
                    'semester'  =>  $status->semester,
                    'title'      =>  $statusDef->title,
                    'abbreviation'  =>  $statusDef->abbreviation,
                ];
            } else {
                $entry = [
                    'year'  =>  $status->year,
                    'semester'  =>  $status->semester,
                    'title'      =>  '?',
                    'abbreviation'  =>  '?',
                ];
            }

            array_push($output, $entry);
        }
        return $output;

    }

    private function createDefaultStatus($member_id, $semester){
        $statusDefs = DB::table('statuses')->get();
        $status = $statusDefs->where('default',true)->first();

        $newStatus = DB::table('user_statuses')->insert([
            'member_id' => $member_id,
            'status_id' => $status->id,
            'year'  =>  Carbon::now()->year,
            'semester'  => $semester,
            'created_at'    => Carbon::now()
        ]);
        return $status;
    }

    public function start_date(){
        if(isset($this->start_date) && $this->start_date !== null){
            return $this->start_date->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function spk_date(){
        if(isset($this->spk_date) && $this->spk_date !== null){
            return $this->spk_date->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function fil_date(){
        if(isset($this->fil_date) && $this->fil_date !== null){
            return $this->fil_date->format('d/m/Y');
        } else {
            return null;
        }
    }

    public function news() {
        $this->hasMany(News::class, 'member_id', 'member_id');
    }
    public function delete(){
        $this->delete();

    }
}

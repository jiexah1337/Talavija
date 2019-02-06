<?php
/**
 * Created by PhpStorm.
 * User: Aleksejs
 * Date: 1/28/2019
 * Time: 11:19 AM
 */

namespace App\Http\Controllers;
use DB;
use Entities\Bio;
use Entities\TimeAndPlace;
use Entities\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Entities\Repatriation;
class RepForGroupsController
{
    public function index(Request $request){
        $start_date=$request->start_date;
        $title=$request->title;
        $Value =$request->Value;
        $Reason =$request->Reason;
        $for_groups=$request->for_groups;
        $variables=$this->fillTable($for_groups,$Value,$title,$Reason,$start_date);
        return view('fragments.rep-table')->with('variables',$variables);
    }
    public function fillTable($for_groups, $Value,$title,$Reason,$start_date){

        // foreach lai dabut status id no statusa abbriviaturas un ieraksta to masiva
        $array=str_word_count($for_groups, 1, '!');
        $i=0;
        foreach ($array as $value) {

            $statusid = DB::table('statuses')->where('abbreviation', '=', $value)->value('id');
            $statusidarray[$i]=$statusid;
            $i++;
        }
        // foreach lai dabut lietotaju srakstus kuriem ir status no augsaja foreach
        $i=0;
        foreach($statusidarray as $value){
            $users[$i] = DB::table('user_statuses')->Where('status_id', '=', $value)->pluck('member_id');
            $i++;
        }
        $i=0;
        foreach ($users as $member_id){
            foreach ($member_id as $id){
                $mirus=Bio::query()->where('member_id','=',$id)->value('deathdata_id');
                $Discount=Repatriation::query()->where('member_id',$id)->value('discount');
                if(null == TimeAndPlace::query()->where('location_id','=',$mirus)->value('date') ) {

                    $lietotajs = User::query()->where('member_id', '=', $id)->get();
                    $rep[$i] =
                        array(
                            "title" => $title,
                            "reason" => $Reason,
                            "start_date" => $start_date,
                            "member_id" => $id,
                            "name" => $lietotajs[0]->name,
                            "lastname" => $lietotajs[0]->surname,
                            "Value" => $Value,
                            "discount" => $Discount,

                        );
                }
                $i++;
            }
        }

        return $rep;
    }

    public function store(Request $request){
        $title=$request->title;
        $reason=$request->reason;
        $date = new Carbon( ($request->start_date) );

        foreach($request->checkbox as $id){
            $amount=$request->Summa[$id];

            $discount=$request->Discount[$id];

            Repatriation::query()->insert(
                ['member_id' => $id,
                    'year' => $date->year,
                    'month' => $date->month,
                    'title' => $title,
                    'amount' => $amount*-1,
                    'unique_code'=>'Maksajums',
                    'type' => $reason,
                    'discount' => $discount]
            );

        }
        return view('fragments.rep-for-groups');

    }
    public function editReps(Request $request){
        dd($request);

    }
}
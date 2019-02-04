<?php
/**
 * Created by PhpStorm.
 * User: Aleksejs
 * Date: 1/28/2019
 * Time: 11:19 AM
 */

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
                $mirus=DB::table('bios')->where('member_id','=',$id)->value('deathdata_id');

                if(null == DB::table("time_and_places")->where('location_id','=',$mirus)->value('date') ) {

                    $lietotajs = DB::table('users')->where('member_id', '=', $id)->get();
                    $rep[$i] =
                        array(
                            "title" => $title,
                            "reason" => $Reason,
                            "start_date" => $start_date,
                            "member_id" => $id,
                            "name" => $lietotajs[0]->name,
                            "lastname" => $lietotajs[0]->surname,
                            "Value" => $Value,
                            "discount" => 0,

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
            $member_id=$request->member_id[$id];
            $amount=$request->Summa[$id];
            $discount=$request->discount[$id];
            DB::table('repatriations')->insert(
                ['member_id' => $member_id, 'year' => $date->year,'month' => $date->month,'title' => $title,'amount' => $amount, 'type' => $reason,'collected' => 0]
            );

        }
        return view('fragments.rep-for-groups');

    }
    public function editReps(Request $request){
        dd($request);

    }
}
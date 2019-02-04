<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Entities\User as User;
use Sentinel;
use DB;


class RepForGroups extends Controller
{
    public function index(){
        return view('fragments.rep-for-groups');
    }
    public function store(Request $request){

        session_start();

        $start_date=$request->start_date;
        $title=$request->title;
        $Value =$request->Value;
        $Reason =$request->Reason;
        $for_groups=$request->for_groups;
        $variables=$this->fillTable($for_groups,$Value);
        return redirect()->action('RepForGroupsController@index',['variables',$request]);
    }
    public function fillTable($for_groups, $Value){

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
                     $lietotajs = DB::table('users')->where('member_id', '=', $id)->get();
                    $rep[$i] =
                        array(
                            "member_id" => $id,
                            "name" => $lietotajs[0]->name,
                            "lastname" => $lietotajs[0]->surname,
                            "Value" => $Value,
                            "discount" => 0,

                        );

                $i++;
            }
        }

        return $rep;
    }
    public function editReps(request $request){
dd($request);
    }
}

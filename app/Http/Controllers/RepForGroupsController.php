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
use Entities\Status;
use Entities\TimeAndPlace;
use Entities\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Entities\Repatriation;
class RepForGroupsController
{
    public function index(Request $request){


        $variables=$this->fillTable($request);
        return view('fragments.rep-table')->with('variables',$variables);
    }
    public function fillTable(Request $request)
    {

        $start_date = $request->start_date;
        $title = $request->title;
        $Value = $request->Value;
        $Reason = $request->Reason;
        $for_groups = $request->for_groups;
        $array = ($request->toArray()['status']);
        $TimeAndPlace = TimeAndPlace::all()->toArray();
        foreach ($TimeAndPlace as $key => $id) {
            $TimeAndPlace_sorted[$TimeAndPlace[$key]['id']] = $TimeAndPlace[$key];
        }
        $index = 0;
        $i = 0;
        $bio = Bio::all()->toArray();

        foreach ($bio as $user_bio) {

            if ($TimeAndPlace_sorted[$user_bio['deathdata_id']]['date'] != null) {

                $dead_user[$i] = $user_bio['member_id'];
                $i++;
            }
            $index++;
        }

        $statuss = DB::table('user_statuses')->get();
        $statuss = $statuss->toArray();
        $notunique = array_count_values(array_column($statuss, 'member_id'));

        foreach ($notunique as $key => $value) {
            if ($value > 1) {
                $member_id[$i] = $key;
                $i++;
            }
        }
        foreach ($statuss as $status) {

            if (isset($member_id)) {

                if (in_array($status->member_id, $member_id)) {

                    $notunique_status[$status->member_id][$key]['created_at'] = $status->created_at;
                    $notunique_status[$status->member_id][$key]['status_id'] = $status->status_id;
                } else {
                    $unique[$i]['id'] = $key;
                    $unique[$i]['member_id'] = $status->member_id;
                    $unique[$i]['status_id'] = $status->status_id;
                    $i++;
                }
            }

        $key++;
        }

        if (isset($notunique_status)) {
            foreach ($notunique_status as $key => $member) {

                $unique[$i]['id'] = array_search(max($member), $member);
                $unique[$i]['member_id'] = $key;
                $unique[$i]['status_id'] = $notunique_status[$key][$unique[$i]['id']]['status_id'];
                $i++;
            }
        }
        $i = 0;
        $groups = Status::all()->toArray();
        $users = User::all()->toArray();

        $i = 0;
        $Reps = Repatriation::query()
            ->orderBy('id', 'desc')->get()->toArray();

        foreach ($unique as $user) {
            if (isset($Reps[array_search($user['member_id'], array_column($Reps, 'member_id'))]['discount'])) {
                $Discount = $Reps[array_search($user['member_id'], array_column($Reps, 'member_id'))]['discount'];
            } else {
                $Discount = 0;
            }
            $user['status_id'] = $groups[$user['status_id'] - 1]['id'];

            if (in_array($user['status_id'], $array)) {
                $rep[$i] =
                    array(
                        "title" => $title,
                        "reason" => $Reason,
                        "start_date" => $start_date,
                        "member_id" => $user['member_id'],
                        "name" => $users[array_search($user['member_id'],
                            array_column($users, 'member_id'))]['name'],
                        "lastname" => $users[array_search($user['member_id'],
                            array_column($users, 'member_id'))]['surname'],
                        "Value" => $Value,
                        "discount" => $Discount,
                    );
                $i++;

            }
        }
        $users = json_decode($request->toArray()['savereps']);
        if(isset($users)){
            foreach ($users as $user) {
                if(in_array($user->member_id,array_column($rep,'member_id'))==false){
                $rep[$i] =
                    array(
                        "title" => $title,
                        "reason" => $Reason,
                        "start_date" => $start_date,
                        "member_id" => $user->member_id,
                        "name" => $user->name,
                        "lastname" => $user->lastname,
                        "Value" => $Value,
                        "discount" => $user->discount,

                    );
                $i++;
                }
            }
        }
        //piespiedu foreach :D savadak vajadzes kopet daudzos vietas un taisit daudz ifu.. vel vairak..
        if(isset($dead_user)){
        foreach($rep as $key=>$user){
            if(in_array($user['member_id'],$dead_user)){
                unset($rep[$key]);
            }
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
                    'discount' => $discount,
                    'issue_date' => $date]
            );

        }

        $statuses=Status::query()->select('title','id')->get();

        return view('fragments.rep-for-groups')->with("statuses",$statuses);

    }

}
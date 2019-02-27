<?php

namespace App\Http\Controllers;
use Entities\Bio;
use Entities\Repatriation;
use Entities\Status;
use Entities\TimeAndPlace;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Entities\User as User;
use function JmesPath\search;
use function MongoDB\BSON\toJSON;
use Sentinel;
use DB;


class RepForGroups extends Controller
{
    public function index(){

        $statuses=Status::query()->select('title','id')->get();

        return view('fragments.rep-for-groups')->with("statuses",$statuses);
    }
    public function store(Request $request){
        session_start();

        return redirect()->action('RepForGroupsController@index',['variables',$request]);
    }
    public function fillTable( Request $request){

        $Value =$request->Value;
        $for_groups=$request->Members;
//        $Value =123;
//        $for_groups="Liepiņs Artjoms";
    $rep[0]=null;
        $array=str_word_count($for_groups, 1, '!1234567890ĀāČčĒĢĪĶĻŅŠŪŽēģīķļņšūž');
        foreach ($array as $key=>$word){
            $array[$key]=iconv('UTF-8', 'ASCII//TRANSLIT',$word);
            $array[$key]=strtolower($array[$key]);
        }
        $i=0;
        $bio=Bio::all()->toArray();
        $TimeAndPlace=TimeAndPlace::all()->toArray();
        foreach ($TimeAndPlace as $key=>$id){
            $TimeAndPlace_sorted[$TimeAndPlace[$key]['id']]=$TimeAndPlace[$key];
        }
        $index=0;
        $i=0;
        $dead_user[0]=null;
        foreach ($bio as $user_bio){
            if($TimeAndPlace_sorted[$user_bio['deathdata_id']]['date']!=null){
                $dead_user[$i]=$user_bio['member_id'];
                $i++;
            }
            $index++;
        }

        $users=User::all()->toArray();
        $i=0;
        $Reps=Repatriation::query()
            ->orderBy('id','desc')->get()->toArray();

        foreach ($users as $user){
            if(isset($Reps[array_search($user['member_id'],array_column($Reps,'member_id'))]['discount'])) {
                $Discount = $Reps[array_search($user['member_id'], array_column($Reps, 'member_id'))]['discount'];
            }else{
                $Discount=0;
            }
            $name=iconv('UTF-8', 'ASCII//TRANSLIT',$users[array_search($user['member_id'],
                array_column($users,'member_id'))]['name']);
            $lastname=iconv('UTF-8', 'ASCII//TRANSLIT',$users[array_search($user['member_id'],
                array_column($users,'member_id'))]['surname']);
            if(in_array(strtolower($name),$array) and in_array(strtolower($lastname),$array) ){
                if(in_array($user['member_id'],array_column($rep,'member_id'))==false){
                $rep[$i] =
                    array(
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

        }
            return($rep);

    }

    public function search(Request $request){
        //$vards = tas ko ievadija inputa
        $vards=$request->vards;
//        $vards="liepin";
    /// po4emu to ne konvertitsa $name $lastname kogda prihodit $vards iz view 0_0
        //parse from lv to eng
        $vards = iconv('UTF-8', 'ASCII//TRANSLIT',$vards);

        $users = User::all()->toArray();
        $index=0;
            $vards = strtolower($vards);
            foreach ($users as $user) {

                $name = iconv('UTF-8', 'ASCII//TRANSLIT', $user['name']);
                $lastname = iconv('UTF-8', 'ASCII//TRANSLIT', $user['surname']);
                if (strpos(strtolower($name), $vards) !== false or strpos(strtolower($lastname), $vards) !== false) {

                    $name=$user['name'];
                    $lastname=$user['surname'];
                    $member_id=$user['member_id'];
                    $result[$index]=compact("name","lastname","member_id");
                    $index++;
                }
            }

        if(isset($result)){
            return $result;
        }else{
            return false;
        }
    }
}

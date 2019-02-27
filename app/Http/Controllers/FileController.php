<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Entities\Repatriation;
use Entities\Status;
use Illuminate\Http\Request;
use Storage;
use Orchestra\Parser\Xml\Facade as XmlParser;
use DB;
use App\Http\Controllers\Controller;
use Entities\User;


class FileController extends Controller
{
    public function index(){
        return view('fragments.samaksat');
    }
    public function store(Request $request)
    {
        $xml = simplexml_load_file($request->file('xml'));
        $users=User::all()->toArray();
        foreach($users as $key=>$user){
            $users[$key]['name']=strtolower($user['name']);
            $users[$key]['surname']=strtolower($user['surname']);
        }
        $key=0;
        foreach($xml->BkToCstmrAcctRpt->Rpt->Ntry as $ntry){
            $array[$key]['Name_Lastname']=$ntry->NtryDtls->TxDtls->RltdPties->Dbtr->Nm;
            $array[$key]['Name_Lastname']=str_word_count($array[$key]['Name_Lastname'], 1 ,
                'āčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ');

            $array[$key]['Date'] = $ntry->ValDt->Dt;
            $array[$key]['Number'] = $ntry->AcctSvcrRef;
            $array[$key]['Bank'] =  $ntry->BkTxCd->Prtry->Issr;
            $array[$key]['Currency'] =  $ntry->Amt['Ccy'];
            $array[$key]['Amount'] =$ntry->Amt;
            $array[$key]['Per_Kods'] =  $ntry->NtryDtls->TxDtls->RltdPties->Dbtr->Id->PrvtId->Othr->Id;
            $array[$key]['IBAN'] = $ntry->NtryDtls->TxDtls->RltdPties->DbtrAcct->Id->IBAN;
            $array[$key]['Merkis'] =  $ntry->NtryDtls->TxDtls->RmtInf->Ustrd;

            foreach ($users as $user){
                if($user['name'] == strtolower($array[$key]['Name_Lastname'][0])
                    and $user['surname']=strtolower($array[$key]['Name_Lastname'][1])){
                    $array[$key]['member_id']=$user['member_id'];
                }
            }

            $key++;
        }
        $users=DB::table('users')->select('name','surname','member_id')->get();
        $i=0;
        $key=0;

//        foreach ($array as $id){
//
//            $name[$key]=DB::table('users')->where('name','=',iconv("UTF-8", "ISO-8859-1//TRANSLIT",
// $parse[0]))->get();
//            if(isset($name[$key][0])){
//            $key++;
//            }
//        }
        $variables=compact('array','users');
        return view('fragments.payments')->with('variabl',$variables);

    }
    public function payments( Request $request){

        foreach($request->checkbox as $id){
            $member_id=str_word_count($request->Lietotajs[$id], 1 , 'āčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ0123456789');
            $amount=$request['Amount'][$id];


            $unique_code=$request['unique_id'][$id];

            $date = new Carbon( ($request['Date'][$id]));
            /**
             * @var $reps Repatriation[]
             *
             */
//            $row=Repatriation::query()->where('unique_code',$unique_code)->get();
//            if(!isset($row)) {
//

                Repatriation::query()->insert(
                    ['member_id' => $member_id[2],
                        'amount' => $amount,
                        'title' => 0,
                        'type' => 0,
                        'year' => $date->year,
                        'month' => $date->month,
                        'discount' => 0,
                        'unique_code' => $unique_code,
                        'issue_date' => $date]
                );
//            }

        }

        $statuses=Status::query()->select('title','id')->get();

        return view('fragments.rep-for-groups')->with("statuses",$statuses);


    }
}

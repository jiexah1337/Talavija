<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Entities\Repatriation;
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

            $array[$key]['member_id']=DB::table('users')
                ->where('name',$array[$key]['Name_Lastname'][0])
                ->where('surname',$array[$key]['Name_Lastname'][1])->value('member_id');
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


            $member_id=str_word_count($request['Select'][$id], 1 , 'āčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ0123456789');

            $amount=$request['Amount'][$id];

            $date = new Carbon( ($request['Date'][$id]));

            // 


            /**
             * @var $reps Repatriation[]
             *
             */



            $isset[]=DB::table('repatriations')
                ->where('member_id',$member_id[2])
                ->where('collected','0')
                ->where('year',$date->year)
                ->where('month',$date->month)
                ->get();


            if(isset($isset)) {
                DB::table('repatriations')->where('member_id', $member_id[2])->
                where('collected', '0')->where('year', $date->year)->where('month', $date->month)
                    ->update(['collected' => $amount]);
            }else {
                DB::table('repatriations')->insert(
                    ['member_id' => $member_id[2], 'amount' => 0, 'title' => 0,
                        'type' => 0, 'year' => $date->year, 'month' => $date->month, 'collected' => $amount]
                );
            }
        }

    }

}

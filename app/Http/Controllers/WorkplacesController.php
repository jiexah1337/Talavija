<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Entities\Workplace;
use Services\Workplace\WorkplaceFacade as WorkplaceF;
use Entities\User;
use Illuminate\View\View;
use Sentinel;
use Carbon\Carbon as Carbon;
class WorkplacesController extends Controller
{
    public function index($member_id){
        $user = User::where('member_id',$member_id)->first();

        $activeWorkplaces = WorkplaceF::getActive($user->member_id);
        $inactiveWorkplaces = WorkplaceF::getInactive($user->member_id);
        $workplaces = [
            'active'    =>  $activeWorkplaces,
            'inactive'  =>  $inactiveWorkplaces,
        ];

        $canUpdate = (Sentinel::getUser()->hasAccess('user.update')) || Sentinel::getUser()->member_id == $user->member_id;
        $returnHTML = view('fragments.workplace-list',compact(['workplaces', 'canUpdate']))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function store(Request $request){
        $validationErrors = $request->validate([
            'field'         =>  'required',
            'company'       =>  'required',
            'position'      =>  'required',
        ]);

        $sDate = Carbon::createFromDate(
            $request->get('w_start_year'),
            $request->get('w_start_month'),
            $request->get('w_start_day')
        );

        if($request->get('w_end_year') && $request->get('w_end_month') && $request->get('w_end_day') ){
            $eDate = Carbon::createFromDate(
                $request->get('w_end_year'),
                $request->get('w_end_month'),
                $request->get('w_end_day')
            );
        } else {
            $eDate = null;
        }


        DB::Transaction(function() use ($request, $sDate, $eDate){
            $workplace = new Workplace();

            $workplace->field        = $request->get('field');
            $workplace->company      = $request->get('company');
            $workplace->start_date   = $sDate;

            if($eDate){
                $workplace->end_date     = $eDate;
            }
            $workplace->member_id    = $request->get('member_id');
            $workplace->position     = $request->get('position');
            $workplace->save();
    });

        return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
    }

    public function add(Request $request, $member_id){
        $actionurl = '/workplace/store';
        $returnHTML = view('fragments.modals.workplace', compact(['actionurl', 'member_id']))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function edit(Request $request, $id){

        if($request->isMethod('get')){
            $workplace = Workplace::find($id);
            $actionurl = '/workplace/edit/'.$id;
            $returnHTML = view('fragments.modals.workplace', compact(['actionurl', 'workplace']))->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else if ($request->isMethod('post')) {

            $sDate = Carbon::createFromDate(
                $request->get('w_start_year'),
                $request->get('w_start_month'),
                $request->get('w_start_day')
            );

            if($request->get('w_end_year') && $request->get('w_end_month') && $request->get('w_end_day') ){
                $eDate = Carbon::createFromDate(
                    $request->get('w_end_year'),
                    $request->get('w_end_month'),
                    $request->get('w_end_day')
                );
            } else {
                $eDate = null;
            }

            DB::Transaction(function() use ($request,$sDate, $eDate, $id){
                Workplace::find($id)->update([
                    'field'         =>      $request->get('field'),
                    'company'       =>      $request->get('company'),
                    'start_date'    =>      $sDate,
                    'position'      =>      $request->get('position'),
                ]);

                if ($eDate){
                    Workplace::find($id)->update([
                        'end_date'      =>      $eDate,
                    ]);
                } else {
                    Workplace::find($id)->update([
                        'end_date'      =>      null,
                    ]);
                }
            });
            return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
        }
    }

    public function delete (Request $request, $id){
        if($request->isMethod('get')){
            $workplace = Workplace::find($id);
            $actionurl = '/workplace/delete/'.$id;
            $canUpdate = (Sentinel::getUser()->hasAccess('user.update')) || Sentinel::getUser()->member_id == User::where('member_id', Sentinel::getUser()->member_id)->pluck('member_id')->first();
            $partial = view('fragments.workplace', compact(['workplace', 'canUpdate']))->render();
            $memberid = $workplace->member_id;
            $returnHTML = view('fragments.modals.delete', compact(['actionurl', 'workplace', 'partial', 'canUpdate', 'memberid']))->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else if ($request->isMethod('post')) {
            DB::Transaction(function() use ($request, $id){
                Workplace::find($id)->delete();
            });
            return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Entities\Study;
use Services\Study\StudyFacade as StudyF;
use Entities\User;
use Carbon\Carbon as Carbon;
use Sentinel;
class StudiesController extends Controller
{
    public function index($member_id){
        $user = User::where('member_id',$member_id)->first();

        $activeStudies = StudyF::getActive($user->member_id);
        $inactiveStudies = StudyF::getInactive($user->member_id);
        $studies = [
            'active'    =>  $activeStudies,
            'inactive'  =>  $inactiveStudies,
        ];

        $canUpdate = (Sentinel::getUser()->hasAccess('user.update')) || Sentinel::getUser()->member_id == $user->member_id;
        $returnHTML = view('fragments.study-list',compact(['studies', 'canUpdate']))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function store(Request $request){
        $validationErrors = $request->validate([
            'name' => 'required',
        ]);

        $sDate = Carbon::createFromDate(
            $request->get('start_year'),
            $request->get('start_month'),
            $request->get('start_day')
        );

        if($request->get('end_year') && $request->get('end_month') && $request->get('end_day') ){
            $eDate = Carbon::createFromDate(
                $request->get('end_year'),
                $request->get('end_month'),
                $request->get('end_day')
            );
        } else {
            $eDate = null;
        }

        DB::Transaction(function() use ($request, $sDate, $eDate){
            $study = new Study();

            $study->name        = $request->get('name');
            $study->faculty     = $request->get('faculty');
            $study->program     = $request->get('program');
            $study->degree      = $request->get('degree');

            $grad = $request->get('graduated');
            $study->graduated   = isset($grad);
            $study->start_date  = $sDate;

            if($eDate){
                $study->end_date     = $eDate;
            }

            $study->member_id = $request->get('member_id');
            $study->save();

        });

        return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
    }

    public function add(request $request, $member_id){
        $actionurl = '/study/store';
        $returnHTML = view('fragments.modals.study', compact(['actionurl', 'member_id']))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function edit(Request $request, $id){
        if($request->isMethod('get')){
            $study = Study::find($id);
            $actionurl = '/study/edit/'.$id;
            $returnHTML = view('fragments.modals.study', compact(['actionurl', 'study']))->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else if ($request->isMethod('post')) {

            $sDate = Carbon::createFromDate(
                $request->get('start_year'),
                $request->get('start_month'),
                $request->get('start_day')
            );

            if($request->get('end_year') && $request->get('end_month') && $request->get('end_day') ){
                $eDate = Carbon::createFromDate(
                    $request->get('end_year'),
                    $request->get('end_month'),
                    $request->get('end_day')
                );
            } else {
                $eDate = null;
            }

            DB::Transaction(function() use ($request, $id, $sDate, $eDate){
                $grad = $request->get('graduated');
                Study::find($id)->update([
                    'name'          =>  $request->get('name'),
                    'faculty'       =>  $request->get('faculty'),
                    'program'       =>  $request->get('program'),
                    'degree'        =>  $request->get('degree'),


                    'graduated'     =>  isset($grad),
                    'start_date'    =>  $sDate,
                ]);
                if ($eDate){
                    Study::find($id)->update([
                        'end_date'      =>      $eDate,
                    ]);
                } else {
                    Study::find($id)->update([
                        'end_date'      =>  null,
                    ]);
                }
            });
            return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
        }
    }

    public function delete (Request $request, $id){
        if($request->isMethod('get')){
            $study = Study::find($id);
            $actionurl = '/study/delete/'.$id;
            $canUpdate = (Sentinel::getUser()->hasAccess('user.update')) || Sentinel::getUser()->member_id == User::where('member_id', Sentinel::getUser()->member_id)->pluck('member_id')->first();
            $partial = view('fragments.study', compact(['study', 'canUpdate']))->render();
            $memberid = $study->member_id;
            $returnHTML = view('fragments.modals.delete', compact(['actionurl', 'study', 'partial', 'canUpdate', 'memberid']))->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else if ($request->isMethod('post')) {
            DB::Transaction(function() use ($request, $id){
                Study::find($id)->delete();
            });
            return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
        }
    }
}

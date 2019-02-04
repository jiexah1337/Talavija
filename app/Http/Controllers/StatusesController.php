<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Entities\Status as Status;
use Sentinel;
use Entities\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatusesController extends Controller
{
    public function StatusManager(Request $request){
        if($request->isMethod('get')){
            if(Sentinel::getUser()->hasAccess('statuses.view')){
                $statuses = Status::get();
                $returnHTML = view('fragments.admin.status-list', compact(['statuses']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else {
                $returnHTML = view('fragments.access-denied')->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            }
        }
        return '';
    }

    public function StatusEditor(Request $request){
        if(Sentinel::getUser()->hasAccess('statuses.update')){
            if($request->isMethod('get')){
                $statuses = Status::get();
                $returnHTML = view('fragments.admin.status-editor', compact(['statuses']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('post')){
                return response()->json(array('success' => true, 'msg' => 'Stuff Received'));
            }
        }
        $returnHTML = view('fragments.access-denied')->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function StatusCreator(Request $request){
        if(Sentinel::getUser()->hasAccess('statuses.create')){
            if($request->isMethod('get')){
                $actionurl = '/admin/statuses/add';
                $returnHTML = view('fragments.admin.modals.status-creator', compact(['actionurl']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('post')){
                $title = $request->get('status-title');
                $abbr = $request->get('status-abbr');

                Status::create([
                    'title' => $title,
                    'abbreviation'  =>  $abbr,
                    'default'   => false,
                ])->save();
                return response()->json(array('success' => true, 'msg' => 'Stuff Received'));
            }
        }
        $returnHTML = view('fragments.access-denied')->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function StatusDefaulter($status_id){
        if(Sentinel::getUser()->hasAccess('statuses.update')){
            $statuses = Status::get();
            foreach ($statuses as $key=>$status){
                if($status->id != $status_id){
                    $status->default = false;
                } else {
                    $status->default = true;
                }
                $status->save();
            }
            return response()->json(['success' => true, 'msg' => 'Noklusējuma status uzstādīts!']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Jums nav atļaujas veikt šo darbību!']);
        }
    }

    public function StatusDeleter($status_id){
        if(Sentinel::getUser()->hasAccess('statuses.delete')){
            $status = Status::find($status_id)->delete();
            return response()->json(['success' => true, 'msg' => 'Status dzēsts!']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Jums nav atļaujas dzēst šo statusu!']);
        }
    }

    public function DefaultStatusAttach($member_id) {
        $today = Carbon::now();
        $currentSemester = 0;
        if($today->month <= 6){
            $currentSemester = 1;
        } else {
            $currentSemester = 2;
        }
        $status = Status::where('default', 1)->first();
//        dd($status);
        DB::table('user_statuses')->insert([
            'member_id' => $member_id,
            'status_id' =>  $status->id,
            'created_at'    => Carbon::now(),
            'semester'  => $currentSemester,
            'year'  =>  $today->year,
        ]);
    }

    public function StatusAttach(Request $request, $member_id){
        if(Sentinel::getUser()->hasAccess('statuses.attach')){
            $user = User::where('member_id', $member_id)->first();
            if($request->isMethod("get")){
                $statuses = Status::get();
                $actionurl = '/admin/statuses/edit/'.$member_id;
                $returnHTML = view('fragments.modals.status-edit', compact(['statuses', 'actionurl', 'user']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod("post")) {

                $today = Carbon::now();
                $currentSemester = 0;
                if($today->month <= 6){
                    $currentSemester = 1;
                } else {
                    $currentSemester = 2;
                }

                $status = Status::where('id', $request->get('status-select'))->first();

                DB::table('user_statuses')->insert([
                    'member_id' => $member_id,
                    'status_id' =>  $request->get('status-select'),
                    'created_at'    => Carbon::now()->format('Y-m-d '),
                    'semester'  => $currentSemester,
                    'year'  =>  $today->year,
                ]);

                return response()->json(array('success' => true, 'html' => $status->abbreviation));
            }
        }
    }
}

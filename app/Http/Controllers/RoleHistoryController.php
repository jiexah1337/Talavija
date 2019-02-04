<?php

namespace App\Http\Controllers;
use App\Role;
use DB;
use Doctrine\Common\Util\Debug;
use Repositories;
use Services;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Entities\RoleHistory;
use Entities\User;
use Illuminate\View\View;
use Sentinel;
use Carbon\Carbon as Carbon;
use Barryvdh\Debugbar\Facade as Debugbar;

class RoleHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($member_id)
    {
        $roleName = Sentinel::findById($member_id)->roles()->get();
        Debugbar::info($roleName);
        $rolesh = RoleHistory::orderByDesc('start_date')->get();

        Debugbar::info("HELLO");
        Debugbar::info($rolesh);
        $returnHTML = view('fragments.role-history-list', compact('rolesh'))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function idToName($member_id, $role_id)
    {
        return $rolesNames = Sentinel::findById($user->getKey())->roles()->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function add(Request $request, $id){
        if(Sentinel::getUser()->hasAccess('news.post')){
            if($request->isMethod('GET')){
                $actionurl = '/rolehistory/report/add';
                $role = RoleHistory::where('id', $id)->first();
                $returnHTML = view('fragments.modals.report', compact(['actionurl', 'role']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('POST')){
                $validator = Validator::make($request->all(),[
                    'title'         => 'required',
                    'content'            => 'required',
                ])->validate();

                DB::transaction(function() use ($request){
                    RoleHistory::insert([
                        'member_id' =>      Sentinel::getUser()->member_id,
                        'title'     =>      $request->get('title'),
                        'content'   =>      $request->get('content'),
                        'type'      =>      $request->get('type'),
                        'post_date' =>      Carbon::now('Europe/Riga')
                    ])->save();
                });
            }
        }
        return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $member_id)
    {
        if ($request->isMethod('get')){
            Debugbar::info("Here");
            Debugbar::info($member_id);
            Debugbar::info($request->get("role_id"));
            $roleID = $request->get("role_id");
            $roleHistory = RoleHistory::where('member_id', $member_id)->where('role_id', $roleID)->orderByDesc('id')->first();
            Debugbar::info($roleHistory);
            $actionurl = '/rolehistory/edit/'.$member_id;

            try {
                $returnHTML = view('fragments.modals.role-edit', compact(['actionurl', 'roleHistory']))->render();
            } catch (\Throwable $e) {
                return $e;
            }
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else if ($request->isMethod('post')){
            try {
                if (empty($request->get('expire_year')) || empty($request->get('expire_month')) || empty($request->get('expire_day'))) {
                    DB::Transaction(function () use ($request, $member_id) {
                        $roleID = $request->get("role_id");
                        Debugbar::info("VAJADZIGAIS ROLEID: ");
                        Debugbar::info($roleID);
                        $roleHistory = RoleHistory::where('member_id', $member_id)->where('id', $roleID)->orderByDesc('id')->first();
                        $roleHistory->update([
                            'start_date' => Carbon::createFromDate(
                                $request->get('start_year'),
                                $request->get('start_month'),
                                $request->get('start_day')
                            ),
                        ]);
                    });

                } else {
                    DB::Transaction(function () use ($request, $member_id) {
                        $roleID = $request->get("role_id");
                        Debugbar::info("ROLEID IR:");
                        Debugbar::info($roleID);
                        Debugbar::info($member_id);
                        $roleHistory = RoleHistory::where('member_id', $member_id)->where('id', $roleID)->orderByDesc('id')->first();
                        Debugbar::info($roleHistory);
                        $roleHistory->update([
                            'start_date' => Carbon::createFromDate(
                                $request->get('start_year'),
                                $request->get('start_month'),
                                $request->get('start_day')
                            ),
                            'expire_date' => Carbon::createFromDate(
                                $request->get('expire_year'),
                                $request->get('expire_month'),
                                $request->get('expire_day')
                            ),
                        ]);
                    });
                }

            } catch (\Exception $e) {
                return $e;
            } catch (\Throwable $e) {
                return $e;
            }
            return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
//        if(Sentinel::getUser()->hasAccess('rolehistory.delete')){
            $roleHistory = RoleHistory::find($id)->delete();
            return response()->json(['success' => true, 'msg' => 'Status dzēsts!']);
//        } else {
            return response()->json(['success' => false, 'msg' => 'Jums nav atļaujas dzēst šo statusu!']);
//        }
    }

    public function generatePdf($member_id, $id) {
        $pdf = \App::make('dompdf.wrapper');
        $user = User::where('member_id',$member_id)->first();
        $role = RoleHistory::where('member_id', $member_id)->where('id', $id)->first();

        try {
            $html = view('pdf.role-report', compact(['user', 'role']))->render();
        } catch (\Throwable $e) {
            return $e;
        }

        $pdf = PDF::loadHTML($html);
        return $pdf->stream();
//        return view('pdf.bio')->render();
        //return $html;
    }

    public function editReport(Request $request, $id) {
            Debugbar::info($request);
            Debugbar::info("ASAS");
            Debugbar::info($id);
            if($request->isMethod('get')){
                //$user = User::where('member_id', $member_id)->first();
                $role = RoleHistory::where('id', $id)->first();
                $actionurl = '/rolehistory/report/add/'.$id;
                $returnHTML = view('fragments.modals.report', compact(['actionurl', 'role']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('post')) {
                DB::Transaction(function () use ($request, $id) {
                    $role = RoleHistory::where('id', $id)->first();
                    $report = $role->report;
                    Debugbar::info($role);
                    Debugbar::info($role->id);
                    Debugbar::info($request->get('report'));
                    Debugbar::info($report);
                    $role->update([
                        'report' => $request->get('report')
                    ]);
                });
            }
        return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
    }

    public function deleteReport($id) {
//        if(Sentinel::getUser()->hasAccess('statuses.delete')){
            $report = RoleHistory::where('id', $id)->first();
            $report ->update([
                'report' => null
            ]);
//            return response()->json(['success' => true, 'msg' => 'Status dzēsts!']);
//        } else {
//            return response()->json(['success' => false, 'msg' => 'Jums nav atļaujas dzēst šo statusu!']);
//        }
    }

    public function uploadFile(Request $request, $member_id){
        if ($request->isMethod('get')){
            $user = User::where('member_id', $member_id);
            $actionurl = '/rolehistory/report/upload/'.$member_id;
            try {
                $returnHTML = view('fragments.modals.report-file', compact(['actionurl', 'member_id']))->render();
            } catch (\Throwable $e) {
                return $e;
            }
            return response()->json(array('success' => true, 'html' => $returnHTML));

        } else if ($request->isMethod('post')){
            $request->validate([
                'image' =>  '   mimes:jpeg,jpg,png,bmp'
            ]);

            $cropData = json_decode($request->get('crop'));
            $image = Image::make(Input::file('image'))->encode('png');
            $hash = md5($member_id);


            $path = "app/public/avatars/".$hash.'.png';

            try{
                Storage::delete(storage_path($path));
            }catch(\Exception $e) {

            }
            try{
                if (!file_exists(storage_path($path))) {
                    mkdir(storage_path('app/public/avatars'), 666, true);
                }
            } catch(\Exception $e) {

            }

            $image->save(storage_path($path));

            return response()->json(array('success' => true, 'imgHash' => $hash));

        }
        return 0;
    }

    public function getImage($member_id){
//        $hash = md5($member_id);
//        $path = "app\public\avatars\\".$hash.'.png';
//        try {
//            $image = Storage::get(storage_path($path));
//        } catch (FileNotFoundException $e) {
//        }

        $canUpdate = (Sentinel::getUser()->hasAccess('user.update')) || Sentinel::getUser()->member_id == User::where('member_id',$member_id);

        try {
            $returnHTML = view('fragments.user-widget-small', compact($canUpdate))->render();
        } catch (\Throwable $e) {
            return $e;
        }
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


}

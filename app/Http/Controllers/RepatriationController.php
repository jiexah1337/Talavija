<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Entities\Repatriation as Repatriation;
use Illuminate\Http\Request;
use Session;
use Sentinel;
use Entities\User as User;
use DB;

class RepatriationController extends Controller
{
    public function index(Request $request, $page = null, $year = null, $async = null) {
        if(Sentinel::getUser()->hasAccess('money.view')){
            $variables = $this->getReps($page, $year);
            if($async == 'async'){
                $returnHTML = view('fragments.money-table', $variables)->render();
                return response()->json(['success' => true, 'html' => $returnHTML]);
            } else {
                return view('pages.repatriation.main', $variables);
            }
        }
        return redirect('/access-denied');
    }
    private function getReps($page = null, $year = null){
        $rpp = 25;

        if ($year == null || !isset($year)) {
            $cbn = Carbon::today();
            $year = $cbn->year;
        }

        if ($page == null || !isset($page)) {
            $page = 1;
        }

        $users = User::offset($rpp*($page-1))->limit($rpp)->get();
        $count = User::count();
        $pageCount = ceil($count / $rpp);

        $reps = Repatriation::where('year', $year)
            ->whereIn('member_id',
                $users->pluck('member_id')->toArray())
            ->get()->groupBy('member_id');
        $balance=$this->getBalance();
        return compact(['users', 'reps', 'pageCount', 'year', 'page', 'pageCount','balance']);
    }
    private function getBalance(){
        $repss = Repatriation::get()->groupBy('member_id');
        foreach ($repss as $key=>$member_id){
            $bilance=0;
            foreach ($member_id as $id){
                $bilance+=$id->collected-$id->amount;
            }
            $member_id->total_balance=$bilance;

        }
        return $repss;
    }
    public function tableAsync(Request $request, $page = null, $year = null) {
        if(Sentinel::getUser()->hasAccess('money.view')){
            $variables = $this->getReps($page, $year);
//            dd($reps);
            $returnHTML = view('fragments.money-table', $variables)->render();
            return response()->json(['success' => true, 'html' => $returnHTML]);
        }
        $returnHTML = view('fragments.access-denied')->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function editMonth(Request $request, int $member_id, int $year, int $month) {
        if ($request->isMethod('get')){
            if (Sentinel::getUser()->hasAccess('money.view')){
                $user = Sentinel::getUserRepository()->where('member_id', $member_id)->first();
                $reps = Repatriation::where('member_id',$member_id)->where('year', $year)->where('month', $month)->get();
                $actionurl = "/money/".$member_id."/".$year."/".$month;

                $monthName = $this->getMonthName($month);

//                $html =  view('fragments.modals.repatriation-edit', compact(['reps', 'user', 'year', 'month','monthName', 'actionurl']))->render();
//                return response()->json(array('success' => true, 'html' => $html));
                return view('pages.repatriation.individual', compact(['reps', 'user', 'year', 'month','monthName', 'actionurl']));
            } else {
                $returnHTML = view('fragments.access-denied')->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            }
        } else if ($request->isMethod('post')){
            if (Sentinel::getUser()->hasAccess('money.update')){

            }
        }

    }

    public function listMonth(Request $request, int $member_id, int $year, int $month) {
        if (Sentinel::getUser()->hasAccess('money.view')){
            $user = Sentinel::getUserRepository()->where('member_id', $member_id)->first();
            $reps = Repatriation::where('member_id',$member_id)->where('year', $year)->where('month', $month)->get();
            $actionurl = "/money/".$member_id."/".$year."/".$month;

            $monthName = $this->getMonthName($month);

            $returnHTML = view('fragments.repatriation-list', compact(['reps', 'user', 'year', 'month','monthName', 'actionurl']))->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else {
            $returnHTML = view('fragments.access-denied')->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }

    public function listSearch($year, $page, $query = null) {
        if(Sentinel::getUser()->hasAccess('money.view')){
            $query = str_replace(array('(',')'), '', $query);

            $resultType = '';

            if($query != ''){
                $searchValues = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
                $statusSearch = preg_grep("([A-z]+!)", $searchValues);

                $users = User::where(function ($q) use ($searchValues) {
                    foreach ($searchValues as $value) {
                        $q->orWhere('name', 'like', "%{$value}%")
                            ->orWhere('surname', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%")
                            ->orWhere('member_id', 'like', "%{$value}%");
                    }
                })->limit(25)->get();
            }
            else {
                $rpp = 25;
                $users = User::offset($rpp*($page-1))->limit($rpp)->get();
            }


            $reps = Repatriation::where('year', $year)
                ->whereIn('member_id',
                    $users->pluck('member_id')->toArray())
                ->get()->groupBy('member_id');
//            dd($reps);

            $returnHTML = view('fragments.money-table', compact(['users', 'year', 'reps']))->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }

        $returnHTML = view('fragments.access-denied')->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    private function getMonthName(int $month){
        switch ($month){
            case 1: return 'Janvāris';
            case 2: return 'Februāris';
            case 3: return 'Marts';
            case 4: return 'Aprīlis';
            case 5: return 'Maijs';
            case 6: return 'Jūnijs';
            case 7: return 'Jūlijs';
            case 8: return 'Augusts';
            case 9: return 'Septembris';
            case 10: return 'Oktobris';
            case 11: return 'Novembris';
            case 12: return 'Decembris';
            default: return null;
        }
    }

    public function editEntry(Request $request, $repatriation_id = null){
        if(Sentinel::getUser()->hasAccess('money.update')){
            if($request->isMethod('get')){
                $rep = Repatriation::find($repatriation_id);
                $actionurl = '/money/edit/'.$repatriation_id;

                if($rep == null){
                    $year = $request->get('year');
                    $month = $request->get('month');
                    $member_id = $request->get('member');

                    $rep = new Repatriation([
                        'year'  => $year,
                        'month' =>  $month,
                        'issue_date'    => null,
                        'paid_date'     => null

                    ]);

                    $rep->member_id = $member_id;

                    $actionurl = '/money/edit';
                }
                $returnHTML = view('fragments.modals.repatriation-entry-edit', compact(['actionurl', 'rep']))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));

            } else if($request->isMethod('post')){
                $title = $request->get('title');
                $amount = $request->get('amount');
                $type = $request->get('type');
                $year = $request->get('year');
                $month = $request->get('month');
                if($request->has('collect')){
                    $collected = $request->get('collect');
                    if($collected == null){
                        $collected = 0;
                    }
                } else {
                    $collected = 0;
                }


                if(in_array($type, ['Sods','Maksājums','Prēmija','Cits'])){
                    if($repatriation_id !== null){
                        $id = $request->get('id');
                        $rep = Repatriation::where('id', $id)->first();
                        $generatedLoader = '/money/listload/'.$rep->member_id.'/'.$rep->year.'/'.$rep->month;
                        $rep->update([
                            'title' => $title,
                            'type' => $type,
                            'amount' => $amount,
                            'collected' => $collected,
                            'member_id' => $rep->member_id
                        ]);
                        return response()->json(array('success' => true, 'msg' => "Repartīcija rediģēta!", 'gllURL' => $generatedLoader));
//                        return response()->json(array('success' => true, 'msg' => $rep));
                    } else {
                        $member_id = $request->get('member_id');
                        $rep = Repatriation::create([
                            'title' => $title,
                            'type' => $type,
                            'amount' => $amount,
                            'collected' => $collected,
                            'member_id' => $member_id,
                            'year'  =>  $year,
                            'month' => $month
                        ]);

                        if($request->get('issue_year') != null && $request->get('issue_day') != null){
                            $rep->update([
                                'issue_date' => Carbon::createFromDate(
                                    $request->get('issue_year'),
                                    $request->get('issue_month'),
                                    $request->get('issue_day')
                                ),
                            ]);
                        } else {
                            $rep->update([
                                'issue_date' => null
                            ]);
                        }

                        if($request->get('paid_year') != null && $request->get('paid_day') != null){
                            $rep->update([
                                'paid_date' => Carbon::createFromDate(
                                    $request->get('paid_year'),
                                    $request->get('paid_month'),
                                    $request->get('paid_day')
                                ),
                            ]);
                        } else {
                            $rep->update([
                                'paid_date' => null
                            ]);
                        }


                        $generatedLoader = '/money/listload/'.$member_id.'/'.$year.'/'.$month;
                        return response()->json(array('success' => true, 'msg' => "Repartīcija saglabāta!", 'gllURL' => $generatedLoader));
                    }
                }
            }
        }
    }

    public function deleteEntry(Request $request, $repatriation_id){
        if(Sentinel::getUser()->hasAccess("money.update")){
            $rep = Repatriation::find($repatriation_id);
            $generatedLoader = '/money/listload/'.$rep->member_id.'/'.$rep->year.'/'.$rep->month;
            $rep->delete();
            $loaderTarget = "#monthlyList";

            return response()->json(['success' => true, 'msg' => 'Repartīcija dzēsta', 'loaderTrgt' => $loaderTarget, 'loaderLink' => $generatedLoader]);
        }
    }
}

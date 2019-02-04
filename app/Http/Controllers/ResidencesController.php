<?php

namespace App\Http\Controllers;

use Entities\Residence;
use Illuminate\Http\Request;
use Entities\TimeAndPlace;
use Entities\Location;
use Entities\User;
use DB;
use Session;
use Carbon\Carbon as Carbon;
use Validator;
use Services\Residence\ResidenceFacade as ResidenceF;
use Sentinel;
class ResidencesController extends Controller
{
    public function index($member_id){
        $user = User::where('member_id',$member_id)->first();

        $activeResidences = ResidenceF::getActive($user->member_id);
        $inactiveResidences = ResidenceF::getInactive($user->member_id);
        $residences = [
            'active'    =>  $activeResidences,
            'inactive'  =>  $inactiveResidences,
        ];

        $canUpdate = (Sentinel::getUser()->hasAccess('user.update')) || Sentinel::getUser()->member_id == $user->member_id;

        $returnHTML = view('fragments.residence-list',compact(['residences', 'canUpdate']))->render();

        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function currentResidence($member_id){
        $residence = DB::table('residences')->join('locations','residences.location_id', '=', 'locations.id')->where('member_id','=',$member_id)->orderBy('start_date', 'desc')->firstOrDefault()->get();
        return $residence;
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'r_country'         => 'required',
            'r_city'            => 'required',
            'r_address'         => 'required',
        ])->validate();

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

        DB::transaction(function() use ($request, $sDate, $eDate){
            $location = new Location();
            $residence = new Residence();

            $location->country  = $request->get('r_country');
            $location->city     = $request->get('r_city');
            $location->address  = $request->get('r_address');
            $location->notes     = $request->get('r_notes');

            $location->save();

            $residence->location_id = $location->id;
            $residence->member_id   = $request->get('member_id');
            $residence->start_date  = $sDate;

            if ($eDate){
                $residence->end_date    = $eDate;
            }

            $residence->save();

        });
        return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
    }

    public function add(Request $reques, $member_id){
        $actionurl = '/residence/store';
        $returnHTML = view('fragments.modals.residence', compact(['actionurl', 'member_id']))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function edit(Request $request, $id){
        if($request->isMethod('get')){
            $residence = Residence::find($id);
            $actionurl = '/residence/edit/'.$id;
            $returnHTML = view('fragments.modals.residence', compact(['actionurl', 'residence']))->render();
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
                $residence  =   Residence::find($id);
                $location   =   Location::where('id',$residence->location_id);

                $location->update([
                    'country'           =>  $request->get('r_country'),
                    'city'              =>  $request->get('r_city'),
                    'address'           =>  $request->get('r_address'),
                    'notes'             =>  $request->get('r_notes'),
                ]);

                $residence->update([
                    'start_date'        => $sDate,
                ]);

                if ($eDate){
                    $residence->update([
                        'end_date'          => $eDate,
                    ]);
                } else {
                    $residence->update([
                        'end_date'          => null,
                    ]);
                }
            });
            return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
        }
    }

    public function delete (Request $request, $id){
        if($request->isMethod('get')){
            $residence = Residence::find($id);
            $actionurl = '/residence/delete/'.$id;
            $canUpdate = (Sentinel::getUser()->hasAccess('user.update')) || Sentinel::getUser()->member_id == User::where('member_id', Sentinel::getUser()->member_id)->pluck('member_id')->first();
            $partial = view('fragments.residence', compact(['residence', 'canUpdate']))->render();
            $memberid = $residence->member_id;
            $returnHTML = view('fragments.modals.delete', compact(['actionurl', 'residence', 'partial', 'canUpdate', 'memberid']))->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else if ($request->isMethod('post')) {
            DB::Transaction(function() use ($request, $id){
                $residence  =   Residence::find($id);
                $location   =   Location::where('id',$residence->location_id);

                $residence->delete();
                $location->delete();
            });
            return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
        }
    }
}

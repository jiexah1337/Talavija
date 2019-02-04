<?php

namespace App\Http\Controllers;

use Entities;
use Repositories;
use Services;
use Illuminate\Http\Request;
use Sentinel;
use Carbon\Carbon as Carbon;
use Entities\User;
use Session;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use Services\Workplace\WorkplaceFacade as Workplace;
use Services\Study\StudyFacade as Study;
use Services\Residence\ResidenceFacade as Residence;
use Services\Bio\BioFacade as Bio;
use Barryvdh\Debugbar\Facade as Debugbar;
use Services\TimeAndPlace\TimeAndPlaceFacade as TAP;
use Validator;

class BiosController extends Controller
{
    /**
     * This is responsible for displaying biography pages
     * @param null $member_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showBioPage($member_id = null){
        if(isset($member_id)){
            $user = User::where('member_id',$member_id)->first();
        }else{
            // The reason why we don't do $user = Sentinel::getUser() is because of there being 2 models with name User - one is from Sentinel, the other - custom, and they don't share methods and parameters
            $user = User::where('member_id',Sentinel::getUser()->member_id)->first();
        }
        DebugBar::info('Member ID is '.$member_id);


        //Useful for when quickly checking if a user is registered. No need to manually go to register page if you encounter a situation where the user isn't present
        if(!$user){
            if(Sentinel::getUser()->hasAccess('user.create')){
                Debugbar::info('User not found, Redirecting to user creation...');
                return redirect('/users/register');
            } else {
                return redirect(route('access-denied'));
            }

        }

        if(Sentinel::getUser()->hasAccess('user.view') || Sentinel::getUser()->member_id == $user->member_id){
            $bio = Bio::getBio($user->member_id);
            if($bio === null){
                Debugbar::warning('Bio not found, Generating default Bio with Member ID: '.$user->member_id);
                $bio = Bio::createDefault($user->member_id);
            }



            //START WORKPLACE, STUDY, RESIDENCE LOAD
            Debugbar::info('Bio page loader : Loading Active Workplaces...');
            $activeWorkplaces = Workplace::getActive($user->member_id);

            Debugbar::info('Bio page loader : Loading Inactive Workplaces...');
            $inactiveWorkplaces = Workplace::getInactive($user->member_id);

            Debugbar::info('Bio page loader : Combining Workplace Lists...');
            $workplaces = [
                'active'    =>  $activeWorkplaces,
                'inactive'  =>  $inactiveWorkplaces,
            ];



            Debugbar::info('Bio page loader : Loading Active Studies...');
            $activeStudies = Study::getActive($user->member_id);

            Debugbar::info('Bio page loader : Loading Inactive Studies...');
            $inactiveStudies = Study::getInactive($user->member_id);

            Debugbar::info('Bio page loader : Combining Study Lists...');
            $studies = [
                'active'    =>  $activeStudies,
                'inactive'  =>  $inactiveStudies,
            ];



            Debugbar::info('Bio page loader : Loading Active Residences...');
            $activeResidences = Residence::getActive($user->member_id);

            Debugbar::info('Bio page loader : Loading Inactive Residences...');
            $inactiveResidences = Residence::getInactive($user->member_id);

            Debugbar::info('Bio page loader : Combining Residence Lists...');
            $residences = [
                'active'    =>  $activeResidences,
                'inactive'  =>  $inactiveResidences,
            ];

            //END WORKPLACE, STUDY, RESIDENCE LOAD



            $children = $this->getChildren($bio);
            $otherfam = $this->getOtherfam($bio);


            //These are used to change what gets displayed.
            $canUpdate = (Sentinel::getUser()->hasAccess('user.update')) || Sentinel::getUser()->member_id == $user->member_id;     //Is it allowed to edit the bio page
            $bzUpdate = Sentinel::getUser()->hasAccess('user.notes');                                                               //Is it allowed to edit "Biedrzina Piezimes"
            $canUpdateRoles = (Sentinel::getUser()->hasAccess('roles.attach'));                                                     //Is it allowed to change user Roles
            $canUpdateStatus = (Sentinel::getUser()->hasAccess('statuses.attach'));                                                 //Is it allowed to change user Status
            $isDead = false;                                                                                                        //Self explanatory. Used to determine if a more gray appearance is needed for Bio


            if (isset($bio->deathdata->date)) {
                $isDead = true;
            }


            $variables = compact(['user','bio','isDead', 'workplaces','studies','residences', 'canUpdate', 'bzUpdate', 'canUpdateRoles', 'canUpdateStatus', /*'deceased',*/ 'children', 'otherfam']);
//            dd($variables);
            return view('pages.user.bio', $variables);
        }
        return redirect(route('accessDenied'));

        "compact(): Undefined variable: deceased";
   }


    /**
     * This is a mess. The .PDF generator is annoying and only supports css up to CSS2.
     * @param $member_id
     * @return \Exception|\Illuminate\Http\Response|\Throwable
     */
    public function generatePdf($member_id) {
        $pdf = \App::make('dompdf.wrapper');
        $user = User::where('member_id',$member_id)->first();


        try {
            $html = view('pdf.bio', compact(['user']))->render();
        } catch (\Throwable $e) {
            return $e;
        }

        $pdf = PDF::loadHTML($html);
        return $pdf->stream();
//        return view('pdf.bio')->render();
        //return $html;
    }

    /**
     * @param Request $request
     * @param $member_id
     * @return \Exception|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response|\Throwable
     */
    public function editNotes(Request $request, $member_id) {
        dd($request);
        if(Sentinel::getUser()->hasAccess('user.notes')){
            if ($request->isMethod('get')){
                //This part displays the modal
                $user = User::where('member_id', $member_id)->first();

                $actionurl = '/bio/notes/edit/'.$member_id;
                $bio = $user->bio;

                try {
                    $returnHTML = view('fragments.modals.notes', compact(['actionurl', 'bio', 'member_id']))->render();
                } catch (\Throwable $e) {
                    return $e;
                }
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('post')){
                //This part deals with data updates
                try {
                    DB::Transaction(function () use ($request, $member_id) {
                        $user = User::where('member_id', $member_id)->first();
                        $bio = $user->bio;

                        $bio->update([
                            'notes' => $request->get('notes')
                        ]);
                    });
                } catch (\Exception $e) {
                    return $e;
                } catch (\Throwable $e) {
                    return $e;
                }
                return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
            }
        }
        return \Response(['status' => 'fail', 'msg' => 'Nav atļaujas veikt darbību!']);
    }

    /**
     * This deals with the actual Biography part of the bio. AKA the big text editor
     * @param Request $request
     * @param $member_id
     * @return \Exception|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response|\Throwable
     */
    public function editBio(Request $request, $member_id) {
        if ($request->isMethod('get')){

            $user = User::where('member_id', $member_id)->first();

            $actionurl = '/bio/biography/edit/'.$member_id;
            $bio = $user->bio;

            try {
                $returnHTML = view('fragments.modals.bio', compact(['actionurl', 'bio', 'member_id']))->render();
            } catch (\Throwable $e) {
                return $e;
            }
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else if ($request->isMethod('post')){
            try {
                DB::Transaction(function () use ($request, $member_id) {
                    $user = User::where('member_id', $member_id)->first();
                    $bio = $user->bio;

                    $bio->update([
                        'bio' => $request->get('bio')
                    ]);
                });
            } catch (\Exception $e) {
                return $e;
            } catch (\Throwable $e) {
                return $e;
            }
            return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotes($member_id) {
        $user = User::where('member_id',$member_id)->first();
        $notes = $user->bio->notes;
        return response()->json(array('success' => true, 'html'=>$notes));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBiography($member_id) {
        $user = User::where('member_id',$member_id)->first();
        $bio = $user->bio->bio;
        return response()->json(array('success' => true, 'html'=>$bio));
    }

    /**
     * Base is Name, Surname, Birth data, Current residence, Contact info, Death info and Date when user joined
     * @return \Exception|\Illuminate\Http\JsonResponse|\Throwable
     */
    public function getBase($member_id) {
        $user = User::where('member_id',$member_id)->first();
        $bio = $user->bio;
        try {
            $returnHTML = view('fragments.bio-base', compact(['user', 'bio', 'member_id']))->render();
        } catch (\Throwable $e) {
            return $e;
        }
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    /**
     * @param Request $request
     * @param $member_id
     * @return \Exception|\Illuminate\Http\JsonResponse|int|\Throwable
     * @throws \Throwable
     */
    public function editBase(Request $request, $member_id){
        if(Sentinel::getUser()->hasAccess('user.update') || Sentinel::getUser()->member_id == $member_id){
            if ($request->isMethod('get')){
                $user = User::where('member_id', $member_id)->first();
                $bio = $user->bio;
                $actionurl = '/bio/base/edit/'.$member_id;

                try {
                    $returnHTML = view('fragments.modals.bio-base', compact(['actionurl', 'bio', 'member_id']))->render();
                } catch (\Throwable $e) {
                    return $e;
                }
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('post')) {
                $user = User::where('member_id', $member_id)->first();

                //If the old password is present in the form, we assume they want it changed
                if ($request->get('old_pwd') != '') {
                    $hasher = Sentinel::getHasher();

                    //if Old password is correct and the new one is a confirmed match...
                    if ($hasher->check($request->get('old_pwd'), $user->password) && $request->get('new_pwd') == $request->get('cnfrm_pwd')) {
                        $validator = Validator::make($request->all(),[
                            'new_pwd'   =>  'min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'
                        ]);
                        if($validator->fails()){
                            return response()->json(['message' => 'Parolei jāsatur : (A-Z), (a-z), (0-9), (!, #, $, %, u.c)']);
                        } else {
                            Sentinel::update($user, ['password' => $request->get('new_pwd')]);
                        }
                    } else {
                        return response()->json(['message' => 'Pārdbaudiet vai esat ievadījuši valīdu veco paroli un vai jaunās paroles lauki sakrīt!']);
                    }
                }

                $bio = $user->bio;
                try {
                    DB::Transaction(function () use ($request, $bio, $user) {
                        $birthdata = $bio->birthdata;
                        $birthlocation = $birthdata->location;
                        $uCon = new UsersController;
                        $deathdata = $bio->deathdata;

                        //On the offchance that a deathdata wasn't generated. This was an issue in an older version but is kept here in case an automated registration fails to do so.
                        if (!$deathdata) {
                            //TAP = Time and Place
                            $deathdata = TAP::createDefault();
                            $bio->update([
                                'deathdata_id' => $deathdata->id,
                            ]);
                        }

                        $deathlocation = $deathdata->location;

                        $birthdata->update([
                            'date' => Carbon::createFromDate(
                                $request->get('birth_year'),
                                $request->get('birth_month'),
                                $request->get('birth_day')
                            ),
                        ]);

                        $birthlocation->update([
                            'country' => $request->get('b_country'),
                            'city' => $request->get('b_city'),
                            'address' => $request->get('b_address'),
                            'notes' => $request->get('b_other'),
                        ]);

                        //Absence of death date means that person is or should be alive
                        if (empty($request->get('deceased_year')) || empty($request->get('deceased_month')) || empty($request->get('deceased_day'))) {
                            $deathdata->update([
                                'date' => null,
                            ]);
                        } else {
                            $deathdata->update([
                                'date' => Carbon::createFromDate(
                                    $request->get('deceased_year'),
                                    $request->get('deceased_month'),
                                    $request->get('deceased_day')
                                ),
                            ]);
                        }

                        $deathlocation->update([
                            'country' => $request->get('d_country'),
                            'city' => $request->get('d_city'),
                            'address' => $request->get('d_address'),
                            'notes' => $request->get('d_other'),
                        ]);

                        $email = $request->get('email');
                        if($email == null){
                            $email = $user->name.'.'.$user->surname.'.'.$user->member_id.'@talavija-nomail.lv';
                        }

                        $user->update([
                            'name' => $request->get('name'),
                            'surname' => $request->get('surname'),
                            'email' => $email,
                            'phone' => $request->get('phone'),
                        ]);

                        if(Sentinel::getUser()->hasAccess('user.assoc')){
                            try{
                                $olderParse = $uCon->stringRegisterParser($request->get('olderman_input'));
                                $colFathParse = $uCon->stringRegisterParser($request->get('col_father_input'));
                                $colMothParse = $uCon->stringRegisterParser($request->get('col_mother_input'));
                                $bio->update([
                                    'olderman_id' => $olderParse["member_id"],
                                    'col_father_id' => $colFathParse["member_id"],
                                    'col_mother_id' => $colMothParse["member_id"],
                                ]);

                                $uCon->missingUser($olderParse);
                                $uCon->missingUser($colFathParse);
                                $uCon->missingUser($colMothParse);
                            } catch(Exception $e){
                                $msg = 'Kļūme apstrādājot Old!, K!Tēva vai K!Mātes datus. Lūdzu pārbaudiet ievadīto informāciju!';
                                return response()->json(['error' => $msg], 500);
                            }



                        }


                        if(Sentinel::getUser()->hasAccess('user.history')){
                            if($request->get('start_year') != null && $request->get('start_day') != null){
                                $user->update([
                                    'start_date' => Carbon::createFromDate(
                                        $request->get('start_year'),
                                        $request->get('start_month'),
                                        $request->get('start_day')
                                    ),
                                ]);
                            } else {
                                $user->update([
                                    'start_date' => null
                                ]);
                            }

                            if($request->get('spk_year') != null && $request->get('spk_day') != null){
                                $user->update([
                                    'spk_date' => Carbon::createFromDate(
                                        $request->get('spk_year'),
                                        $request->get('spk_month'),
                                        $request->get('spk_day')
                                    ),
                                ]);
                            } else {
                                $user->update([
                                    'spk_date' => null
                                ]);
                            }

                            if($request->get('fil_year') != null && $request->get('fil_day') != null){
                                $user->update([
                                    'fil_date' => Carbon::createFromDate(
                                        $request->get('fil_year'),
                                        $request->get('fil_month'),
                                        $request->get('fil_day')
                                    ),
                                ]);
                            } else {
                                $user->update([
                                    'fil_date' => null
                                ]);
                            }
                        }
                    });
                } catch (\Throwable $e) {
                    throw $e;
                }
            }
        }
        return 0;
    }

    /**
     * Associated users - Olderman, Color father and Color mother (Oldermanis, K!tevs, k!mate)
     * @return \Exception|\Illuminate\Http\JsonResponse|\Throwable
     */

    public function getFamily($member_id) {
        $user = User::where('member_id',$member_id)->first();
        $bio = $user->bio;
        $children = $this->getChildren($bio);
        $otherfam = $this->getOtherfam($bio);
        try {
            $returnHTML = view('fragments.bio-family', compact(['user', 'bio', 'children', 'otherfam', 'member_id']))->render();
        } catch (\Throwable $e) {
            return $e;
        }
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function editFamily(Request $request, $member_id){
        if ($request->isMethod('get')){
            $user = User::where('member_id', $member_id)->first();
            $bio = $user->bio;
            $actionurl = '/bio/family/edit/'.$member_id;

            try {
                $returnHTML = view('fragments.modals.bio-family', compact(['actionurl', 'bio', 'member_id']))->render();
            } catch (\Throwable $e) {
                return $e;
            }
            return response()->json(array('success' => true, 'html' => $returnHTML));
        } else if ($request->isMethod('post')) {
            $user = User::where('member_id', $member_id)->first();
            $bio = $user->bio;

            DB::Transaction(function () use ($request, $bio, $user) {

                $bio->update([
                    'father'        =>      $request->get('father'),
                    'mother'        =>      $request->get('mother'),
                    'children'      =>      json_encode(explode(',',$request->get('children'))),
                    'otherfamily'      =>      json_encode(explode(',',$request->get('other'))),
                ]);
            });
        }
        return 0;
    }

    public function setRoles(Request $request, $member_id){
        if (Sentinel::getUser()->hasAccess("user.update")) {
            $user = User::where('member_id', $member_id)->first();
            if ($request->isMethod('get')){
                $actionurl = '/bio/roles/edit/'.$member_id;
                $roles = $user->roles()->get();
                try {
                    $returnHTML = view('fragments.modals.role-edit', compact(['actionurl', 'roles', 'user']))->render();
                } catch (\Throwable $e) {
                    return $e;
                }
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('post')) {
                $data = $request->get('data');

                $processed = [];
                foreach($data as $key=>$entry){
                    $split = explode('|', $entry);
                    array_push($processed, ["role" => $split[0], "value" => $split[1]]);
                }

                foreach ($processed as $key=>$entry){
                    $role = Sentinel::getRoleRepository()->findBySlug($entry["role"]);

                    if(filter_var($entry["value"], FILTER_VALIDATE_BOOLEAN) == true) {
                        if(!$user->inRole($role)){
                            $role->users()->attach($user);
                        }
                    } else {
                        if($user->inRole($role)) {
                            $role->users()->detach($user);
                        }
                    }
                }
            }
        }
    }

    public function getRoles() {
        $member_id = Session::get('member_id');
        $user = User::where('member_id',$member_id)->first();
        try {
            $returnHTML = view('fragments.bio-roles', compact(['user']))->render();
        } catch (\Throwable $e) {
            return $e;
        }
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    private function getChildren($bio){

        return json_decode($bio->children);
    }

    private function getOtherfam($bio){
        return json_decode($bio->otherfamily);
    }
}


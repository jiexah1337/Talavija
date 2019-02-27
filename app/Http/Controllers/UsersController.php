<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;
use Entities\News;
use Entities\Repatriation;
use Entities\Residence;
use Entities\Study;
use Entities\Workplace;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Sentinel;
use Entities\User;
use Entities\Bio;
use Entities\TimeAndPlace;
use Entities\Location;
use Session;
use DB;
use Illuminate\Support\Facades\Validator as Validator;
use Illuminate\Support\Facades\Input as Input;
use Services\TimeAndPlace\TimeAndPlaceFacade as TimeAndPlaceF;
use Illuminate\Support\Facades\Storage as Storage;
use Intervention\Image\Facades\Image as Image;
use Entities\Status as Status;

//use Mail;
//use App\Mail\ActivationMail;

class UsersController extends Controller
{
    /**
     * @param string $input
     * @return array
     * @throws \Exception
     */
    public function stringRegisterParser($input){
        if($input != null){
            try
            {
                $data = explode(' ', $input);
                $parsed = [
                    'name' =>  $data[0],
                    'surname'   =>  $data[1],
                    'member_id' =>  (int) str_replace(array('(',')'),'',$data[2])
                ];

                if (is_string($parsed['name']) && is_string($parsed['surname']) && is_int($parsed['member_id'])) {
                    return $parsed;
                }
                else {
                    throw new \Exception('Incorrect RegisterParser Input! Please check your data! : '.$input);
                }
            } catch (\Exception $e)
            {
                throw new Exception('Incorrect RegisterParser Input! Please check your data! : '.$input);
            }

        }
        return null;
    }

    public function registerUser(Request $request){
//        dd($request);
        if(Sentinel::getUser()->hasAccess('user.create')){
            $statuses = Status::get();
            DebugBar::info('User Controller is registering a new user...');
            Sentinel::setModel(User::class);
            if ($request->isMethod('post')){
                //dd($request->all());
                $request->validate([
                    'member_id'     => 'required|unique:users',
                    'name'          => 'required',
                    'surname'       => 'required',
                    'email'         => 'nullable|email|unique:users',
                    'phone'         => 'nullable|unique:users|phone:AUTO',

                    'birth_day'    => 'required',
                    'birth_month'    => 'required',
                    'birth_year'    => 'required',
                    'deceased_day' => 'nullable',
                    'deceased_month' => 'nullable',
                    'deceased_year' => 'nullable',
                ]);
                DebugBar::info('Validation passed');
                //User table data

                $credentials = [
                    'member_id' => $request->get('member_id'),
                    'name'      => $request->get('name'),
                    'surname'   => $request->get('surname'),
                    'phone'     => $request->get('phone'),
                    'password'  => 'placeholder',
                ];
                if($request->get('email') != null) {
                    $credentials = array_merge($credentials, [
                        'email' => $request->get('email'),
                    ]);
                } else if($request->get('deceased_year') != null && $request->get('deceased_day') != null ) {
                    $credentials = array_merge($credentials,[
                        'email'     => $credentials['name'].'.'.$credentials['surname'].$credentials['member_id'].'@talavija-nomail.lv',
                    ]);
                } else {
                    $credentials = array_merge($credentials,[
                        'email'     => $credentials['name'].'.'.$credentials['surname'].$credentials['member_id'].'@talavija-nomail.lv',
                    ]);
                }

                try {
                    DB::transaction(function () use ($request, $credentials) {
                        DebugBar::info('Started transaction for user creation');
                        DebugBar::info('Registering user...');
                        $user = Sentinel::registerAndActivate($credentials);
                        DebugBar::info('User Registered!');
                        //Bio table data

                        //Birth info
                        DebugBar::info('Creating User Birthplace');
                        $birthplace = new Location([
                            'country' => $request->get('b_country'),
                            'city' => $request->get('b_city'),
                            'address' => $request->get('b_address'),
                            'notes' => $request->get('b_other'),
                        ]);
                        DebugBar::info('Birthplace created...saving');
                        $birthplace->save();
                        DebugBar::info('Birthplace saved! Creating Birth TAP');
                        $birthdata = TimeAndPlace::create([
                            'date' => Carbon::createFromDate(
                                $request->get('birth_year'),
                                $request->get('birth_month'),
                                $request->get('birth_day')
                            ),
                            'location_id' => $birthplace->id,
                        ]);
                        DebugBar::info('Birth TAP created. Saving...');
                        $birthdata->save();
                        DebugBar::info('Birth TAP saved!');

                        //Death info
                        DebugBar::info('Creating death location');
                        if ($request->get('deceased_year') != null && $request->get('deceased_day') != null ) {
                            $deathplace = Location::create([
                                'country' => $request->get('d_country'),
                                'city' => $request->get('d_city'),
                                'address' => $request->get('d_address'),
                                'notes' => $request->get('d_other'),
                            ]);
                            DebugBar::info('Death place created. Saving...');

                            $deathplace->save();
                            DebugBar::info('Death place saved! Creating death TAP');

                            $deathdata = TimeAndPlace::create([
                                'date' => Carbon::createFromDate(
                                    $request->get('deceased_year'),
                                    $request->get('deceased_month'),
                                    $request->get('deceased_day')
                                ),
                                'location_id' => $deathplace->id,
                            ]);
                            DebugBar::info('Death TAP created! Saving...');

                            $deathdata->save();
                            DebugBar::info('Death TAP Saved!');
                        } else {
                            $deathdata = TimeAndPlaceF::createDefault();
                        }
                        DebugBar::info('Creating BIO for new user');

                        $olderParse = $this->stringRegisterParser($request->get('olderman_input'));
                        $colFathParse = $this->stringRegisterParser($request->get('col_father_input'));
                        $colMothParse = $this->stringRegisterParser($request->get('col_mother_input'));

                        $bio = Bio::create([
                            'member_id' => $request->get('member_id'),
                            'olderman_id' => $olderParse["member_id"],
                            'col_father_id' => $colFathParse["member_id"],
                            'col_mother_id' => $colMothParse["member_id"],
                            'birthdata_id' => $birthdata->id,
                            'deathdata_id' => $deathdata->id,
                        ]);

                        DebugBar::info('Bio created!');


                        DebugBar::info('Checking Olderman.');
                        $this->missingUser($olderParse);


                        DebugBar::info('Checking Colour Father');
                        $this->missingUser($colFathParse);


                        DebugBar::info('Checking Colour Mother');
                        $this->missingUser($colMothParse);


                        DebugBar::info('Saving BIO!');
                        $bio->save();

                        $sCon = new StatusesController();
                        if(!Sentinel::getUser()->hasAccess('statuses.attach')){
                            $sCon->DefaultStatusAttach($bio->member_id);
                        } else {
                            $sCon->StatusAttach(Request::create('', 'POST', ['status-select' => $request->get('status')]), $bio->member_id);
                        }

                        if($request->get('start_year') != null && $request->get('start_day') != null){
                            $user->start_date = Carbon::createFromDate(
                                $request->get('start_year'),
                                $request->get('start_month'),
                                $request->get('start_day')
                            );
                        }

                        if($request->get('spk_year') != null && $request->get('spk_day') != null) {
                            $user->spk_date = Carbon::createFromDate(
                                $request->get('spk_year'),
                                $request->get('spk_month'),
                                $request->get('spk_day')
                            );
                        }

                        if($request->get('fil_year') != null && $request->get('fil_day') != null) {
                            $user->fil_date = Carbon::createFromDate(
                                $request->get('fil_year'),
                                $request->get('fil_month'),
                                $request->get('fil_day')
                            );
                        }

                        $user->save();



//                        $defaultRole = Sentinel::getRoleRepository()->findBySlug("z!");
//                        $defaultRole = Sentinel::getRoleRepository()->findBySlug("z!");
//                        $defaultRole->users()->attach($user);
                    });
                } catch (\Exception $e) {
                    throw $e;
                } catch (\Throwable $e) {
                    throw $e;
                }
                DebugBar::info('Redirecting to user!');
                return redirect('/bio/'.$request->get('member_id'));
            }
            return view('auth.register', compact(['statuses']));
        }
        else {
            return redirect('/access-denied');
        }

    }

    public function index($page = 1, $async = null){
        if(Sentinel::getUser()->hasAccess('user.view')){
            $rpp = 25;
            $count = User::count();
            $pageCount = ceil($count / $rpp);
            $users = User::orderBy('member_id')->offset($rpp*($page-1))->limit($rpp)->get();
            if ($async == 'async')
            {
                $returnHTML = view('fragments.user-table', compact(['users', 'pageCount', 'page']))->render();
                return response()->json(['success' => true, 'html' => $returnHTML]);
            } else {
                return view('pages.user.list', compact(['users', 'pageCount', 'page']));
            }
        }

        return redirect('/access-denied');
    }

    public function customValidation($type, $data)
    {
        $popoverMsg = '';
        if ($type == 'mId') {
            $user = User::where('member_id', $data)->first();
            $valid = $user == null;
            if (!$valid) {
                $popoverMsg = "Lietotājs jau reģistrēts! <a href='/bio/$user->member_id'> $user->name $user->surname </a>";
            }
        }

        if ($type == 'phone') {
            $valid = false;
            $data = str_replace(' ', '', $data);
            $validatable = ['phone' => $data];
            $validator = Validator::make($validatable, [
                'phone' => 'phone:AUTO'
            ]);

            $exists = User::where('phone', $data)->exists();

            if (!$validator->fails() && !$exists) {
                $valid = true;
            } else {
                if ($validator->fails()) {
                    $popoverMsg = "Telefona numura formāts neatbilst atļautajam!";
                } else if ($exists) {
                    $popoverMsg = "Telefona numurs jau reģistrēts!";
                }
            }
        }

        if ($type == 'email') {
            $valid = false;
            $validatable = ['email' => $data];
            $validator = Validator::make($validatable, [
                'email' => 'email'
            ]);

            $exists = User::where('email', $data)->exists();

            if (!$validator->fails() && !$exists) {
                $valid = true;
            } else {
                if ($validator->fails()) {
                    $popoverMsg = "E-pasta formāts neatbilst atļautajam!";
                } else if ($exists) {
                    $popoverMsg = "E-pasts jau reģistrēts!";
                }
            }
        }

        if ($type == 'name') {
            $valid = false;
            $validatable = ['name' => $data];
            $validator = Validator::make($validatable, [
                'name' => 'alpha'
            ]);

            if (!$validator->fails()) {
                $valid = true;
            } else {
                if($validator->fails()) {
                    $popoverMsg = "Vārda formāts neatbilst atļautajam!";
                }
            }
        }

        if ($type == 'surname') {
            $valid = false;
            $validatable = ['surname' => $data];
            $validator = Validator::make($validatable, [
                'surname' => 'alpha'
            ]);

            if (!$validator->fails()) {
                $valid = true;
            } else {
                if($validator->fails()) {
                    $popoverMsg = "Uzvārda formāts neatbilst atļautajam!";
                }
            }
        }

        $response = array(
            'type' => $type,
            'data' => $data,
            'valid' => $valid,
            'popperContent' => $popoverMsg
        );

        return \Response::json($response);

    }

    public function authUser(Request $request){
        if($request->isMethod('post')){

            $validation = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];

            Sentinel::authenticate($credentials);

            if($user = Sentinel::check()){
                Session::put('usr_Name',$user->name);
                Session::put('usr_Surname',$user->surname);
                Session::put('usr_Email',$user->email);
                return redirect('/main');
            }
            return view('auth.login');
        }
        return view('auth.login');
    }

    public function profile($member_id){
        $user = Sentinel::getUserRepository()->where('member_id', $member_id)->get()->first();
        $bio = $user->bio;
        return view('pages.user.profile', compact('user','bio'));
    }

    public function logout(){
        Sentinel::logout();
        Session::flush();
        return redirect('/login');
    }

    public function userJson($member_id)
    {
        $user = User::where('member_id', $member_id)->first();

        if($user !== null){
            $response = array(
                'status' => 'success',
                'name' => $user->name,
                'surname' => $user->surname,
            );
        }else{
            $response = array(
                'status' => 'failure',
                'name' => null,
                'surname' => null,
            );
        }

        return \Response::json($response);
    }

    public function search(Request $request, $query){
        $class = $request->get('class');

        $query = str_replace(array('(',')'), '', $query);
        $searchValues = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
        $resultType = '';

        $users = User::where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
                $q->orWhere('name', 'like', "%{$value}%")
                ->orWhere('surname', 'like', "%{$value}%")
                ->orWhere('member_id', 'like', "%{$value}%");
            }
        })->limit(5)->get();


        //Assumptions made
        $name = isset($searchValues[0])? $searchValues[0] : ' ';
        $surname = isset($searchValues[1])? $searchValues[1] : ' ';
        $mId = isset($searchValues[2])? $searchValues[2] : ' ';


        $exists = User::where('name', "{$name}")->Where('surname', "{$surname}")->Where('member_id', "{$mId}")->exists();

        $returnHTML = view('fragments.user-dropdown', compact(['users', 'class']))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML, 'exists' => $exists));
    }

    public function listSearch($page, $query = null) {
        $query = str_replace(array('(',')'), '', $query);

        if($query != ''){
            $searchValues = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
            $resultType = '';

            $users = User::where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                        ->orWhere('surname', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('member_id', 'like', "%{$value}%");
                }
            })->limit(25)->get();
        } else {
            $rpp = 25;
            $users = User::orderBy('member_id')->offset($rpp*($page-1))->limit($rpp)->get();
        }


        $returnHTML = view('fragments.user-table', compact(['users']))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function missingUser($data) {
        DebugBar::warning('Users Controller | Missing User : ATTEMPTING TO GENERATE A MISSING USER WITH THE MEMBER ID: '.$data['member_id']);

        if($data != null){
            DB::Transaction(function() use ($data){
                DebugBar::info('Users Controller | Missing User : Double Checking if user exists...');
                if (!User::where('member_id', $data["member_id"])->exists()) {
                    DebugBar::info('Users Controller | Missing User : User does not exist. Generating new...');
                    $user = User::create([
                        'member_id'     =>  $data["member_id"],
                        'name'          =>  $data["name"],
                        'surname'       =>  $data["surname"],
                        'email'         =>  $data["name"].'.'.$data["surname"].'.'.$data["member_id"].'@talavija.lv',
                        'password'      =>  'placeholder',
                    ]);
                    DebugBar::info('Users Controller | Missing User : User created');

                    $user->save();
                    DebugBar::info('Users Controller | Missing User : User saved!');
                    DebugBar::info('Users Controller | Generating default TAP for missing user');
                    $birthdata = TimeAndPlaceF::createDefault();

                    DebugBar::info('Users Controller | Generating Bio for missing user');
                    $bio = Bio::create([
                        'member_id'     =>  $data["member_id"],
                        'birthdata_id'  =>  $birthdata->id,
                        'deathdata_id'  =>  -1,
                    ]);
                    //dd($bio);
                    $bio->save();
                }
            });
        }
    }

    public function editImage(Request $request, $member_id) {
        if ($request->isMethod('get')){
            $user = User::where('member_id', $member_id);
            $actionurl = '/users/img/edit/'.$member_id;
            try {
                $returnHTML = view('fragments.modals.profile-image', compact(['actionurl', 'member_id']))->render();
            } catch (\Throwable $e) {
                return $e;
            }
            return response()->json(array('success' => true, 'html' => $returnHTML));

        } else if ($request->isMethod('post')){
            $request->validate([
                'image' =>  '   mimes:jpeg,jpg,png,bmp'
            ]);

            $cropData = json_decode($request->get('crop'));
            $image = Image::make(Input::file('image'))->crop($cropData->width, $cropData->height, $cropData->x, $cropData->y)->fit(500)->encode('png');
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

            $thumb = $image->resize(100,100);
            $path = "app/public/avatars/thumbnails/".$hash.'.png';

            try{
                Storage::delete(storage_path($path));
            }catch(\Exception $e) {

            }
            try{
                if (!file_exists(storage_path($path))) {
                    mkdir(storage_path('app/public/avatars/thumbnails'), 666, true);
                }
            } catch(\Exception $e) {

            }

            $thumb->save(storage_path($path));
            //$path = Storage::putFileAs('public/avatars', $image,$member_id.'.png');
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
    public function deleteUser(){
        $member_id = $_GET['id'];
        $user_id=User::query()->where('member_id',$member_id)->value('id');
        DB::table('users')->where('member_id',$member_id)->delete();
        $timeandplaces_id=Bio::query()->select('birthdata_id','deathdata_id')
            ->where('member_id',$member_id)->get();

        DB::table('activations')->where('user_id',$user_id)->delete();
        Bio::query()->where('member_id',$member_id)->delete();
        DB::table('persistences')->where('user_id',$user_id)->delete();
        DB::table('reminders')->where('user_id',$user_id)->delete();
        Repatriation::query()->where('member_id',$member_id)->delete();
        News::query()->where('member_id',$member_id)->delete();

        $locations_id=Residence::query()->select('location_id')->where('member_id',$member_id)->get();
        if(isset($locations_id[0]['location_id'])){
        DB::table('locations')->where('id',$locations_id[0]['location_id'])->delete();
        }
        Residence::query()->where('member_id',$member_id)->delete();
        DB::table('role_history')->where('member_id',$member_id)->delete();
        DB::table('role_users')->where('user_id',$user_id)->delete();
        Study::query()->where('member_id',$member_id)->delete();
        DB::table('throttle')->where('user_id',$user_id)->delete();
        if(isset($timeandplaces_id[0])) {
            DB::table('time_and_places')->where('location_id', $timeandplaces_id[0]['birthhdata_id'])->delete();
            DB::table('time_and_places')->where('location_id', $timeandplaces_id[0]['deathdata_id'])->delete();
        }
        DB::table('user_statuses')->where('member_id',$member_id)->delete();
        Workplace::query()->where('member_id',$member_id)->delete();
    }
}

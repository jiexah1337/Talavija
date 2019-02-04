<?php

namespace App\Http\Controllers;

use App\Mail\ActivationMail;
use App\Mail\TestMail;
use Mail;
use Sentinel;
use Illuminate\Http\Request;
use Entities\News;
use Entities\User as User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //NEWS SECTION VARIABLES
        $ppp = 25; //Posts Per Page
        $count = News::count();
        $pageCount = ceil($count / $ppp);
        //NEWS SECTION VARIABLES


        return view('pages.main', compact(['pageCount']));
    }

    public function accessDenied(){
        $title = 'Jums nav atļaujas peikļūt šajai lapai!';
        $content = 'Ja jums šķiet, ka jums jābūt piekļuvei šajai lapai, paziņojiet sistēmas administratoram par šo kļūmi';

        return view('pages.error', compact(['title','content']));
    }

    public function serverDown(){
        $title = 'Servera problēma!';
        $content = 'Paziņojiet sistēmas administratoram par šo kļūmi, iekļaujot soļus ko veicāt pirms nonācāt šajā lapā!';

        return view('pages.error', compact(['title','content']));
    }

    public function mailTest(){
        $user = Sentinel::getUser();
        $user = User::where('member_id', $user->member_id)->first();
        Mail::to($user->email)->send(new TestMail($user));
    }
}

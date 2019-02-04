<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Entities\News;
use Carbon\Carbon;
use Sentinel;
use Validator;
use DB;

class NewsController extends Controller
{
    public function index($page = 1){
        $ppp = 25; //Posts Per Page
        $count = News::count();
        $pageCount = ceil($count / $ppp);

        $news = News::orderByDesc('post_date')->offset($ppp*($page-1))->limit(25)->get();
        $html = view('fragments.news-list', compact(['news','pageCount']))->render();

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function add(request $request){
        if(Sentinel::getUser()->hasAccess('news.post')){
            if($request->isMethod('GET')){
                $actionurl = '/news/add';
                $returnHTML = view('fragments.modals.news', compact('actionurl'))->render();
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else if ($request->isMethod('POST')){
                $validator = Validator::make($request->all(),[
                    'title'         => 'required',
                    'content'            => 'required',
                ])->validate();

                DB::transaction(function() use ($request){
                    News::create([
                        'member_id' =>      Sentinel::getUser()->member_id,
                        'title'     =>      $request->get('title'),
                        'content'   =>      $request->get('content'),
                        'type'      =>      $request->get('type'),
                        'post_date' =>      Carbon::now('Europe/Riga')
                    ])->save();
                });
                return \Response(['status' => 'success', 'msg' => 'Dati saglabāti!']);
            }

        }
    }
}

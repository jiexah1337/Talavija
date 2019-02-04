<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
    
class MapController extends Controller
{
    public function index($location)
    {
        Mapper::map(53.381128999999990000, -1.470085000000040000);
        Mapper::renderJavascript();
        Mapper::render();

        $returnHTML = view('fragments.modals.map')->render();
        $id = 0;
        //$returnHTML = view('cornford.googlmapper.map', compact(['id']))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}

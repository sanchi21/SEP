<?php namespace App\Http\Controllers;

use App\Hardware;
use App\Http\Requests;
use App\Resource;
use App\Http\Controllers\Controller;

use App\Type;
use Illuminate\Http\Request;

class ResourceController extends Controller {

	public function index()
    {
        $types = Type::all();
        $id = "Office-Equipment";
        $key = 'CMB/OEQ/001';
        return view ('addResource',compact('types','id','key'));
    }

    public function hardware($id)
    {
        $types = Type::all();
        $key = 'CMB/OEQ/002';
        return view ('addResource',compact('types','id','key'));
    }

}

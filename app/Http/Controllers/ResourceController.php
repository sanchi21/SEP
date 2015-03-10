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
        $resources = Resource::all();
        $types = Type::all();
        return view ('addResource',compact('types','resources'));
    }

}

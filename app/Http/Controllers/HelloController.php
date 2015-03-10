<?php
/**
 * Created by PhpStorm.
 * User: sanchi
 * Date: 3/2/2015
 * Time: 11:24 AM
 */

namespace App\Http\Controllers;



class HelloController extends Controller {

    public function myFunction()
    {
        return view('hello');
    }

}
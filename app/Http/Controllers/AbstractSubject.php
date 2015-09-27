<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/26/2015
 * Time: 12:54 PM
 */

abstract class AbstractSubject {

    abstract function attach(AbstractObserver $observerIn);
    abstract function detach(AbstractObserver $observerIn);
    abstract function notify();

} 
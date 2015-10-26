<?php namespace App\Http\Controllers;


abstract class AbstractSubject {

    abstract function attach(AbstractObserver $observerIn);
    abstract function detach(AbstractObserver $observerIn);
    abstract function notify();

} 
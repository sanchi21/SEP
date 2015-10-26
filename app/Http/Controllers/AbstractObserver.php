<?php namespace App\Http\Controllers;


abstract class AbstractObserver {

    abstract function update(AbstractSubject $subject);
} 
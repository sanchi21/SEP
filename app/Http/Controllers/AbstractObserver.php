<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/26/2015
 * Time: 12:57 PM
 */

abstract class AbstractObserver {

    abstract function update(AbstractSubject $subject);
} 
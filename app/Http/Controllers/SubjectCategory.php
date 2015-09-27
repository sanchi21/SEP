<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/26/2015
 * Time: 1:02 PM
 */

class SubjectCategory extends AbstractSubject {

    private $observers = array();
    private $category = 'All';

    function attach(AbstractObserver $observerIn)
    {
        $this->observers[] = $observerIn;
    }

    function detach(AbstractObserver $observerIn)
    {
        foreach ($this->observers as $observerKey => $observerVal)
        {
            if($observerVal == $observerIn)
                unset($this->observers[$observerKey]);
        }

    }

    function notify()
    {
        $columnNames = array();

        foreach($this->observers as $observer)
        {
            $columnNames [] = $observer->update($this);
        }

        return $columnNames;
    }

    public function updateCategory($cat)
    {
        $this->category = $cat;
        $obs = $this->notify();
        return $obs;
    }

    public function getCategory()
    {
        return $this->category;
    }
}
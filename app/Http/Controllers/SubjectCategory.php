<?php namespace App\Http\Controllers;


class SubjectCategory extends AbstractSubject {

    //array to hold observers
    private $observers = array();

    //variable to hold category
    private $category = 'All';

    /**
     * to attach an observer
     *
     *
     * @param AbstractObserver
     */
    function attach(AbstractObserver $observerIn)
    {
        $this->observers[] = $observerIn;
    }

    /**
     * to detach an observer
     *
     *
     * @param AbstractObserver
     */
    function detach(AbstractObserver $observerIn)
    {
        foreach ($this->observers as $observerKey => $observerVal)
        {
            if($observerVal == $observerIn)
                unset($this->observers[$observerKey]);
        }

    }

    /**
     * notify changes
     *
     */
    function notify()
    {
        $columnNames = array();

        foreach($this->observers as $observer)
        {
            $columnNames [] = $observer->update($this);
        }

        return $columnNames;
    }


    /**
     * to update category
     *
     *
     * @param cat
     * @return observer
     */
    public function updateCategory($cat)
    {
        //get the category
        $this->category = $cat;

        //notify the change to the observer
        $obs = $this->notify();

        return $obs;
    }

    /**
     * to get category
     *
     *
     * @return category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
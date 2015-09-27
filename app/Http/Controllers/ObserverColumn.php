<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/26/2015
 * Time: 1:17 PM
 */
use App\Column;

class ObserverColumn extends AbstractObserver {


    /**
     * to update observer
     *
     *
     * @param AbstractSubject
     * @return observer
     */
    function update(AbstractSubject $subject)
    {
        //get the category changed
        $category = $subject->getCategory();

        //update column observer according to the category
        $columns = Column::join('types','types.category','=','columns.category')->where('types.category', $category)->get();

        return $columns;
    }
}
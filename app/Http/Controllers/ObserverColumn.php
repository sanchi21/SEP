<?php namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/26/2015
 * Time: 1:17 PM
 */
use App\Column;

class ObserverColumn extends AbstractObserver {


    function update(AbstractSubject $subject)
    {
        $category = $subject->getCategory();
        $columns = Column::join('types','types.category','=','columns.category')->where('types.category', $category)->get();

        return $columns;
    }
}
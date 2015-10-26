<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/26/2015
 * Time: 4:05 PM
 */

namespace App\Http\Controllers;

use App\Column;

class ObserverValueColumn extends AbstractObserver {

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
        $columns = Column::join('types','types.category','=','columns.category')->where('types.category', $category)
            ->Where('columns.column_type', 'string_currency')
            ->orWhere('columns.column_type', 'integer')
            ->orWhere('columns.column_type', 'double')
            ->orWhere('columns.column_type', 'float')
            ->orWhere('columns.column_type', 'bigInteger')
            ->get();

        return $columns;
    }
} 
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

    function update(AbstractSubject $subject)
    {
        $category = $subject->getCategory();
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
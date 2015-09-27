<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/26/2015
 * Time: 4:07 PM
 */

namespace App\Http\Controllers;

use App\Column;

class ObserverDateColumn extends AbstractObserver{

    function update(AbstractSubject $subject)
    {
        $category = $subject->getCategory();
        $columns = Column::join('types','types.category','=','columns.category')->where('types.category', $category)
            ->Where('columns.column_type', 'date')
            ->orWhere('columns.column_type', 'datetime')
            ->get();

        return $columns;
    }
} 
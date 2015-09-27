<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;


class MonthlyExpensesController extends Controller {

    /**
     * Loads the blade page with given attributes
     * return View
     *
     * @return $this
     */

    Public function getMonthlyExpenses()
    {

        /* In first view or in load make all the attributes null */

        $requestId="";
        $paymentMethod="";
        $total="";
        $orderDate="";
        $totalCost="";
        $mainDate="";
        $remarks="";
        $cost="";
        $totalCostMain=0;

        /* Return the view to the blade page */

        return view('Requests.MonthlyExpenses')->with('mainDate',$mainDate)->with('remarks',$remarks)->with('cost',$cost)->with('totalCostMain',$totalCostMain)->with('orderDate', $orderDate)->with('requestId', $requestId)->with('paymentMethod', $paymentMethod)->with('total', $total)->with('totalCost', $totalCost);

    }


    /**
     * View monthly expenditure of hardware resources
     * inputs month and year
     * returns tthe cost information
     *
     * @return $this
     *
     */

    Public function ViewMonthlyExpenses()
    {

        try {

            /* Get the month and year from view*/

            $month = Input::get('month');
            $year = Input::get('year');

            $yearMonth = $year . '-' . $month;

            /* Get all the dates from orders where the status is purchased*/

            $getDates = DB::table('orders')->where('status', '=', 'Purchased')->get();

            $getMaintenance = DB::table('maintenance')->get();

            /* Initialize variables*/

            $a = 0;
            $b = 0;
            $totalCost = 0;
            $totalCostMain = 0;
            $total = "";
            $paymentMethod = "";
            $requestId = "";
            $orderDate = "";
            $totalCost = "";
            $mainDate = "";
            $remarks = "";
            $cost = "";

            /* Check whether the purchased date and the retrieved dates are the same*/

            foreach ($getDates as $get) {

                $date = $get->order_date;
                $separateDate = (explode("-", $date));
                $newYearMonth = $separateDate[0] . '-' . $separateDate[1];

                $checkCondition = strcmp($yearMonth, $newYearMonth);

                /* If dates ares same save the relevant purchase information*/

                if ($checkCondition == 0) {

                    $requestId[$b] = $get->request_id;
                    $paymentMethod[$b] = $get->payment_method;
                    $total[$b] = $get->total;
                    $orderDate[$b] = $get->order_date;
                    $totalCost = $totalCost + $get->total;
                    $b++;

                }

            }

            /* Check whether the maintenance date and the retrieved dates are the same*/

            foreach ($getMaintenance as $gm) {

                $maintenanceDate = $gm->date;
                $separateDateMain = (explode("-", $maintenanceDate));
                $newYearMonthMain = $separateDateMain[0] . '-' . $separateDateMain[1];

                $checkConditionMain = strcmp($yearMonth, $newYearMonthMain);

                /* If dates ares same save the relevant maintenance information*/

                if ($checkConditionMain == 0) {

                    $remarks[$a] = $gm->remarks;
                    $cost[$a] = $gm->cost;
                    $mainDate[$a] = $gm->date;
                    $totalCostMain = $totalCostMain + $gm->cost;
                    $a++;

                }


            }

            /*  Make sure there are data which has to be sent to view */

            if (sizeof($total) != 0 || sizeof($cost) != 0) {

                return view('Requests.MonthlyExpenses')->with('mainDate', $mainDate)->with('remarks', $remarks)->with('cost', $cost)->with('totalCostMain', $totalCostMain)->with('orderDate', $orderDate)->with('requestId', $requestId)->with('paymentMethod', $paymentMethod)->with('total', $total)->with('totalCost', $totalCost);

            } else {

                \Session::flash('flash_message_error', 'Less no of Licenses/ cannot allocate');
                return redirect('MonthlyExpenses')->with('mainDate', $mainDate)->with('remarks', $remarks)->with('cost', $cost)->with('totalCostMain', $totalCostMain)->with('orderDate', $orderDate)->with('requestId', $requestId)->with('paymentMethod', $paymentMethod)->with('total', $total)->with('totalCost', $totalCost);

            }

        }

        catch (\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }

}

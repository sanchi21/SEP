<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\DB;

use Request;

class ProcumentReport extends Controller {


	public function requestVendorReports()
	{
        $vendors = DB::table('procurement_items')
            ->join('vendors', 'procurement_items.vendor_id', '=', 'vendors.vendor_id')
            ->select('procurement_items.pRequest_no','procurement_items.status', 'vendors.vendor_name', 'vendors.addrss','vendors.phone','vendors.email')
            ->get();

		return view('ProcumentReports.procumentReport')->with('vendors',$vendors);
	}


    public function acceptedRequestReports()
    {
//        $pRequests = DB::table('procurement_items')
//            ->where('status',"Approved")->groupBy('pRequest_no')->get();

        $pRequests = DB::table('procurement_items')
            ->join('vendors', 'procurement_items.vendor_id', '=', 'vendors.vendor_id')
            ->select('procurement_items.pRequest_no','procurement_items.vendor_id', 'vendors.vendor_name', 'procurement_items.item_no',
                'procurement_items.description','procurement_items.quantity','procurement_items.price_tax', 'procurement_items.warranty')
            ->get();

        return view('ProcumentReports.procumentReport')->with('pRequests',$pRequests);
    }

    public function orderReports()
    {
        $orders = DB::table('orders')->get();

        return view('ProcumentReports.procumentReport')->with('orders',$orders);
    }

    public function requestVendorReportsPost()
    {
        $input = Request::all();

        $sortColumn = $input['sortBy'];

        if($sortColumn=='vendor_name')
        {
            $vendors = DB::table('procurement_items')
                ->join('vendors', 'procurement_items.vendor_id', '=', 'vendors.vendor_id')
                ->select('procurement_items.pRequest_no','procurement_items.status', 'vendors.vendor_name', 'vendors.addrss','vendors.phone','vendors.email')
                ->orderBy('vendors.vendor_name')
                ->get();

            return view('ProcumentReports.procumentReport')->with('vendors',$vendors);

        }

        else
        {
            $vendors = DB::table('procurement_items')
                ->join('vendors', 'procurement_items.vendor_id', '=', 'vendors.vendor_id')
                ->select('procurement_items.pRequest_no','procurement_items.status', 'vendors.vendor_name', 'vendors.addrss','vendors.phone','vendors.email')
                ->orderBy('procurement_items.'.$sortColumn)
                ->get();

            return view('ProcumentReports.procumentReport')->with('vendors',$vendors);

        }

    }


    public function acceptedRequestReportsPost()
    {
        $input = Request::all();

        $sortColumn = $input['sortBy'];

        if($sortColumn=='vendor_name')
        {
            $pRequests = DB::table('procurement_items')
                ->join('vendors', 'procurement_items.vendor_id', '=', 'vendors.vendor_id')
                ->select('procurement_items.pRequest_no','procurement_items.vendor_id', 'vendors.vendor_name', 'procurement_items.item_no',
                    'procurement_items.description','procurement_items.quantity','procurement_items.price_tax', 'procurement_items.warranty')
                ->orderBy('vendors.vendor_name')
                ->get();

            return view('ProcumentReports.procumentReport')->with('pRequests',$pRequests);

        }

        else
        {
            $pRequests = DB::table('procurement_items')
                ->join('vendors', 'procurement_items.vendor_id', '=', 'vendors.vendor_id')
                ->select('procurement_items.pRequest_no','procurement_items.vendor_id', 'vendors.vendor_name', 'procurement_items.item_no',
                    'procurement_items.description','procurement_items.quantity','procurement_items.price_tax', 'procurement_items.warranty')
                ->orderBy('procurement_items.'.$sortColumn)
                ->get();

            return view('ProcumentReports.procumentReport')->with('pRequests',$pRequests);

        }


    }

    public function orderReportsPost()
    {

        $input = Request::all();

        $sortColumn = $input['sortBy'];


            $orders = DB::table('orders')->orderBy($sortColumn)->get();

            return view('ProcumentReports.procumentReport')->with('orders',$orders);

    }

}

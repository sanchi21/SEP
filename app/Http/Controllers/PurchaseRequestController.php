<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProcurementItem;
use App\ProcurementRequest;
use App\req;
use App\Vendor;
use Illuminate\Support\Facades\DB;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Exception;

class PurchaseRequestController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('Procument.getVendorsForm');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $vendors = Vendor::all();
        $requestNo = 'PR_'.date('Ymd_His');
        $noOfVendors = Input::get('no_of_vendors');
        $tax = 0.02;
        return view('Procument.purchaseRequestForm',compact('noOfVendors','vendors','requestNo','tax'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        try {
            $input = Request::all();
            $requestNo = $input['request_no'];
            $reason = $input['reason'];
            $approval = $input['approval'];
            $mailCC = $input['mail_cc'];
            $note = $input['note'];
            $vendors = $input['vendor_name'];
            $vendorCount = 1;
            $tax = 0.02;

            $itemData = array();

            foreach ($vendors as $vendor) {
                $itemNos = $input['item_v' . $vendorCount];
                $descriptions = $input['description_v' . $vendorCount];
                $quantities = $input['quantity_v' . $vendorCount];
                $prices = $input['price_v' . $vendorCount];
//            $totalPrices = $input['total_price_v'.$vendorCount];
//            $taxPrices = $input['tax_price_v'.$vendorCount];
                $warranties = $input['warranty_v' . $vendorCount];

                for ($i = 0; $i < count($itemNos); $i++) {
                    $tempData = array();
                    $tempData = array_add($tempData, 'pRequest_no', $requestNo);
                    $tempData = array_add($tempData, 'vendor_id', $vendor);
                    $tempData = array_add($tempData, 'item_no', $itemNos[$i]);
                    $tempData = array_add($tempData, 'description', $descriptions[$i]);
                    $tempData = array_add($tempData, 'quantity', $quantities[$i]);
                    $tempData = array_add($tempData, 'price', $prices[$i]);
                    $total = $quantities[$i] * $prices[$i];
                    $tax_total = $total + ($total * $tax);
                    $tempData = array_add($tempData, 'total_price', $total);
                    $tempData = array_add($tempData, 'price_tax', $tax_total);
                    $tempData = array_add($tempData, 'warranty', $warranties[$i]);

                    array_push($itemData, $tempData);
                }

                $vendorCount++;
            }

            $procurementRequest = new ProcurementRequest();
            $procurementRequest->pRequest_no = $requestNo;
            $procurementRequest->request_date = date('Y-m-d');
            $procurementRequest->reason = $reason;
            $procurementRequest->for_appeal = $approval;

            DB::beginTransaction();
            $procurementRequest->save();
            ProcurementItem::insert($itemData);
            DB::commit();
            \Session::flash('flash_message','Purchase Request Sent Successfully!');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::to('home');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}

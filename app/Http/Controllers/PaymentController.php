<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Request;
use Redirect;
use App\Order;
use Mail;
use URL;

class PaymentController extends Controller {


	public function index()
	{

        $firstRequest = DB::table('procurement_items')
            ->where('status',"Approved")->groupBy('pRequest_no')->first();

        $reqID = $firstRequest->pRequest_no;

        $items = DB::table('procurement_items')
            ->where('status',"Approved")
            ->where('pRequest_no',$reqID)->get();

        $total = DB::table('procurement_items')
            ->selectRaw('pRequest_no, sum(price_tax) as sum')
            ->where('pRequest_no', $reqID)
            ->where('status', "Approved")
            ->groupBy('pRequest_no')
            ->first('sum');


        $requests = DB::table('procurement_items')
            ->where('status',"Approved")->groupBy('pRequest_no')->get();


        return view('payment.payMethod')->with('items', $items)
                                        ->with('requests', $requests)
                                        ->with('reqID',$reqID)
                                        ->with('total',$total);
	}

    public function viewByRequest()

    {

        $input = Request::all();
        $reqID = $input['reqID'];

        $items = DB::table('procurement_items')
            ->where('status',"Approved")
            ->where('pRequest_no',$reqID)->get();

        $requests = DB::table('procurement_items')
            ->where('status',"Approved")->groupBy('pRequest_no')->get();

        $total = DB::table('procurement_items')
            ->selectRaw('pRequest_no, sum(price_tax) as sum')
            ->where('pRequest_no', $reqID)
            ->where('status', "Approved")
            ->groupBy('pRequest_no')
            ->first('sum');

        return view('payment.payMethod')->with('items', $items)
                                        ->with('requests', $requests)
                                        ->with('reqID',$reqID)
                                        ->with('total',$total);
    }

    public function placeOrder()
    {
        $input = Request::all();

        $reqID = $input['reqID'];
        $payMethod = $input['payMethod'];
        $total = $input['total'];
        $orderDate = $input['orderDate'];

        $items = DB::table('procurement_items')
            ->where('status',"Approved")
            ->where('pRequest_no',$reqID)->get();

        $itemsCount = count($items);

//        $vendorID = DB::table('procurement_items')
//            ->select('vendor_id')
//            ->where('status',"Approved")
//            ->where('pRequest_no',$reqID)->get();

//        $status1 = DB::table('users')->whereIn('pRequest_no', $reqID)
//                        ->whereIn('status', "Approved")->update(array('status' => "Ordered"));

//        if($status1)
//            \Session::flash('flash_message','Your Order was successfull');

//        foreach($items as $item)
//        {
//
////            DB::table('procument_items')
////                ->where('request_id', $reqID)
////                ->where('status',"Approved")
////                ->update(array('staus'=>"Ordered"));
//            $item->status = 'Ordered';
//
//        }


        $order = new Order();

        $order->request_id = $reqID;
        $order->payment_method = $payMethod;
        $order->total = $total;
        $order->order_date = $orderDate;
        $order->status = "Ordered";

        $status = $order->save() ? true : false;

        if($status)

        {

            Mail::send('emails.orderDetails', array('reqID'=>$reqID, 'payMethod'=>$payMethod,
                'orderDate'=>$orderDate,'total'=>$total,'items'=>$items,'link' => URL::route('viewInvoice', $reqID)),function($messsage)
            {
                $messsage->to('paarthipank@gmail.com','Parthipan')->subject('New Order');
            });

            \Session::flash('flash_message','Your Order has been placed!');

            return Redirect::action('PaymentController@index');

        }


    }

    public function getOrders()
    {

        $orders = DB::table('orders')
            ->where('status',"Ordered")->groupBy('request_id')->get();



        return view('payment.viewOrders')
                 ->with('orders', $orders);


    }

    public function searchOrders()
    {

            return 'hello';

    }


    public function getInvoice($request_id)
    {

        $reqID = $request_id;

        $items = DB::table('procurement_items')
            ->where('status',"Approved")
            ->where('pRequest_no',$reqID)->get();

        $total = DB::table('procurement_items')
            ->selectRaw('pRequest_no, sum(price_tax) as sum')
            ->where('pRequest_no', $reqID)
            ->where('status', "Approved")
            ->groupBy('pRequest_no')
            ->first('sum');

        return view('payment.viewInvoice')->with('items', $items)
            ->with('reqID',$reqID)
            ->with('total',$total);
    }


    public function updatePurchase()
    {

        $input = Request::all();

        $reqID = $input['reqID'];

        $status = DB::table('orders')->where('request_id', $reqID)
                ->update(array('status'=>"Purchased"));

        if($status)

        {

            \Session::flash('flash_message','Purchase Update was successfull');

            return Redirect::action('PaymentController@getOrders');

        }


    }


}

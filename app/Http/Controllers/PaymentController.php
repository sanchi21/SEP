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
        $chequeNumber = $input['chequeNumber'];
        $payDescription = $input['payDescription'];

        $items = DB::table('procurement_items')
            ->where('status',"Approved")
            ->where('pRequest_no',$reqID)->get();

        $itemsCount = count($items);

        $order = new Order();

        $order->request_id = $reqID;
        $order->payment_method = $payMethod;
        $order->total = $total;
        $order->order_date = $orderDate;
        $order->cheque_number = $chequeNumber;
        $order->pay_description - $payDescription;
        $order->status = "Ordered";

        $status = $order->save() ? true : false;

        if($status)

        {

            Mail::send('emails.orderDetails', array('reqID'=>$reqID, 'payMethod'=>$payMethod,
                'orderDate'=>$orderDate,'total'=>$total,'items'=>$items,'link' => URL::route('viewInvoice', $reqID)),function($messsage)
            {
                $messsage->to('sanchayan@live.com','Parthipan')->subject('New Order');
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
        $input = Request::all();

        $searchKey = $input['searchKey'];

        $orders = DB::table('orders')
            ->where('invoice_id','LIKE', '%'.$searchKey.'%')
            ->orWhere('request_id','LIKE', '%'.$searchKey.'%')
            ->orWhere('payment_method', 'LIKE', '%'.$searchKey.'%')
            ->orWhere('order_date', 'LIKE', '%'.$searchKey.'%')
            ->orWhere('total', 'LIKE', '%'.$searchKey.'%')
            ->groupBy('request_id')
            ->get();

        return view('payment.viewOrders')
            ->with('orders', $orders);

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

            \Session::flash('flash_message','Purchase Update was successful');

            return Redirect::action('PaymentController@getOrders');

        }

    }

    public function sendEmail()
    {
        $input = Request::all();

        $emailBody = $input['emailBody'];
        $reqID = $input['reqID'];

        Mail::send('emails.purchaseDelay', array('reqID'=>$reqID, 'emailBody'=>$emailBody),function($messsage)
        {
            $messsage->to('sanchayan@live.com','Sanchayan')->subject('Purchase Delayed');
        });

        \Session::flash('flash_message','Email Successfully sent!');

        return Redirect::action('PaymentController@getOrders');


    }


}

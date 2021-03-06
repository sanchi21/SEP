<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Note;
use App\PItem;
use App\ProcMailCC;
use App\ProcurementItem;
use App\ProcurementRequest;
use App\req;
use App\Vendor;
use Illuminate\Support\Facades\DB;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Type;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
	public function create($no)
	{
        $vendors = Vendor::all();
        $pItems = PItem::all();
        $requestNo = 'PR_'.date('Ymd_His');
//        $noOfVendors = Input::get('no_of_vendors');
        $noOfVendors = $no;
        $tax = 0.02;
        return view('Procument.purchaseRequestForm',compact('noOfVendors','pItems','vendors','requestNo','tax'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        try
        {
            $input = Input::all();
            $requestNo = $input['request_no'];
            $reason = $input['reason'];
            $approval = $input['approval'];
            $attachment = '';
            $mailCC = '';
            $note = $input['note'];
            $vendors = $input['vendor_name'];
            $sVat = 'NO';

            $vendorCount = 1;
            $tax = 0.02;

            $itemData = array();
            $mailData = array();
            $oMailData = array();

            if(isset($input['s_vat']))
            {
                $sVat = $input['s_vat'];
            }

            foreach ($vendors as $vendor)
            {
                $itemNos = $input['item_v' . $vendorCount];
                $descriptions = $input['description_v' . $vendorCount];
                $quantities = $input['quantity_v' . $vendorCount];
                $prices = $input['price_v' . $vendorCount];
                $warranties = $input['warranty_v' . $vendorCount];
                $sVt = $sVat[$vendorCount-1];
                $vendorName = $vendor;

                if($vendor == 'Other')
                    $vendorName = $input['nv'.$vendorCount];

                for ($i = 0; $i < count($itemNos); $i++) {
                    $tempData = array();
                    $tempData = array_add($tempData, 'pRequest_no', $requestNo);
                    $tempData = array_add($tempData, 'vendor_id', $vendorName);
                    $tempData = array_add($tempData, 'item_no', $itemNos[$i]);
                    $tempData = array_add($tempData, 'description', $descriptions[$i]);
                    $tempData = array_add($tempData, 'quantity', $quantities[$i]);
                    $tempData = array_add($tempData, 'price', $prices[$i]);
                    $total = $quantities[$i] * $prices[$i];
                    $tax_total = $total + ($total * $tax);
                    $tempData = array_add($tempData, 'total_price', $total);
                    $tempData = array_add($tempData, 'price_tax', $tax_total);
                    $tempData = array_add($tempData, 'warranty', $warranties[$i]);
                    $tempData = array_add($tempData, 'status', 'On Process');
                    $tempData = array_add($tempData,'svat',$sVt);

                    array_push($itemData, $tempData);
                }

                $vendorCount++;
            }


            $email = $this->getEmail($approval);
            $procurementRequest = new ProcurementRequest();
            $procurementRequest->pRequest_no = $requestNo;
            $procurementRequest->request_date = date('Y-m-d');
            $procurementRequest->reason = $reason;
            $procurementRequest->for_appeal = $approval;
            $procurementRequest->status = 'On Process';
            $procurementRequest->email = $email;

            if(!is_null(Input::file('attachment')))
            {
                $attachment = Input::file('attachment');
                $destination = 'uploads/';
                $extension = $attachment->getClientOriginalExtension();
                $filename = $requestNo . '_' . rand(1111, 9999) . '.' . $extension;
                $attachment->move($destination, $filename);

                $procurementRequest->path = $destination.$filename;
                $procurementRequest->filename = $attachment->getClientOriginalName();
            }

            $notes = new Note();
            $notes->pRequest_no = $requestNo;
            $notes->type_of_note = 0;
            $notes->note = $note;


            DB::beginTransaction();

            if(isset($input['mail_cc']))
            {
                $mailCC = $input['mail_cc'];
                foreach ($mailCC as $mail)
                {
                    $mailCCs = array();
                    $mailCCs = array_add($mailCCs, 'pRequest_no', $requestNo);
                    $mailCCs = array_add($mailCCs, 'user_name', $mail);
                    array_push($mailData, $mailCCs);
                }
                ProcMailCC::insert($mailData);
            }

            if(isset($input['other_cc']))
            {
                if(trim($input['other_cc']) != '')
                {
                    $otherCC = $input['other_cc'];
                    $oCC = explode(',', $otherCC);

                    foreach ($oCC as $oMail)
                    {

                        $oMailCCs = array();
                        $oMailCCs = array_add($oMailCCs, 'pRequest_no', $requestNo);
                        $oMailCCs = array_add($oMailCCs, 'user_name', $oMail);
                        array_push($oMailData, $oMailCCs);
                        array_push($mailCC, $oMail);
                    }
                    ProcMailCC::insert($oMailData);
                }
            }

            $procurementRequest->save();
            $notes->save();
            ProcurementItem::insert($itemData);
            DB::commit();

            $this->sendEmail($email,$mailCC,$requestNo);

            \Session::flash('flash_message','Purchase Request Sent Successfully!');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::to('/home');
	}

	private function sendEmail($approval,$ccList,$requestNo)
    {

        try
        {
            Mail::send('emails.procurementRequest', array('requestNo' => $requestNo),
                function ($messsage) use ($approval,$ccList)
                {
                    $messsage->to($approval, 'Admin')->cc($ccList)->subject('Procurement Request');
                });
        }
        catch(Exception $e)
        {

        }
    }

    private function getEmail($uid)
    {
        $email = '';
        if($uid == '1')
            $email = 'sabhayans@gmail.com';
        elseif($uid == '2')
            $email = 'pathnithyasri@gmail.com';
        elseif($uid == '3')
            $email = 'paarthipank@gmail.com';
        else
            $email = 'sanchayan@live.com';

        return $email;
    }

    public function inventoryView($id)
    {
        $items = ProcurementItem::where('pRequest_no',$id)->where('status','Approved')->join('p_items','procurement_items.item_no','=','p_items.id')->get();
        $types = Type::all();

        return view('Procument.addToInventory',compact('items','types'));
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

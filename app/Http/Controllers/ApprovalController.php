<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\requesth;
use Input;
use Illuminate\Support\Facades\DB;
use App\ProcurementRequest;
use App\ProcurementItem;
use App\Note;
use Auth;
use App\file;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class ApprovalController extends Controller {

    Public function ViewApproval(){

        $viewRequests=ProcurementRequest::where('status', '=','On Process')->get();
        $id=Input::get('');

        $requestStatus="";
        $requestPath="";

        $procurementStatus=DB::table('procurement_status')->get();
        $requestedItems=ProcurementItem::where('pRequest_no', '=',$id);

        $vendors=ProcurementItem::where('pRequest_no', '=',$id)->groupBy('vendor_id')->get();
        $users = DB::table('system_users')->get();

        return view('Requests.Approval')->with('users',$users)->with('requestPath',$requestPath)->with('id',$id)->with('requestStatus',$requestStatus)->with('viewRequests',$viewRequests)->with('procurementStatus',$procurementStatus)->with('requestedItems',$requestedItems)->with('vendors',$vendors);
    }

//--------------------------------------------------View all procurement request items-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    Public function ViewRequestsApp(){

    try {

        $id = Input::get('request_no');

        $requestStatus = ProcurementRequest::where('pRequest_no', '=', $id)->pluck('status');
        $requestPath = ProcurementRequest::where('pRequest_no', '=', $id)->pluck('path');
        $requestedItems = ProcurementItem::where('pRequest_no', '=', $id)->get();

        $vendors = ProcurementItem::where('pRequest_no', '=', $id)->groupBy('vendor_id')->get();
        $procurementStatus = DB::table('procurement_status')->get();

        $viewRequests = ProcurementRequest::where('status', '=', 'On Process')->get();
        $users = DB::table('system_users')->get();

        \Session::flash('flash_viewApprovalRequests', '');
        return view('Requests.Approval')->with('users', $users)->with('requestPath', $requestPath)->with('requestStatus', $requestStatus)->with('id', $id)->with('viewRequests', $viewRequests)->with('requestedItems', $requestedItems)->with('vendors', $vendors)->with('procurementStatus', $procurementStatus);
    }

    catch(\Exception $e)
    {
        return Redirect::back()->withErrors($e->getMessage());
    }

    }

//Update changes in procurement request items and save changes
//-------------------------------------------------------------Update Changes From Blade page-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    Public function UpdateChanges()
    {

    try {

        $cancel = Input::get('cancel');
        $save = Input::get('save');

        if ($cancel) {

            $users = DB::table('system_users')->get();
            $decision=Input::get('valueApprovalCancel');

            $pRequest_nos = Input::get('pRequest_nos');
            $requestedItems = ProcurementItem::where('pRequest_no', '=', $pRequest_nos)->get();
            $vendors = ProcurementItem::where('pRequest_no', '=', $pRequest_nos)->groupBy('vendor_id')->get();

            $procurementStatus = DB::table('procurement_status')->get();
            $viewRequests = ProcurementRequest::where('status', '=', 'On Process')->get();
            $requestStatus = ProcurementRequest::where('pRequest_no', '=', $pRequest_nos)->pluck('status');

            if($decision=='true') {

                \Session::flash('flash_viewApprovalRequests', '');
                \Session::flash('flash_message_CancelModification', 'Modifications Are Not Saved');
                return view('Requests.Approval')->with('users', $users)->with('requestStatus', $requestStatus)->with('id', $pRequest_nos)->with('viewRequests', $viewRequests)->with('requestedItems', $requestedItems)->with('vendors', $vendors)->with('procurementStatus', $procurementStatus);
            }
        }

        if ($save) {

//          get values from blade

            $pRequest_nos = Input::get('pRequest_nos');
            $pRequest_no = Input::get('pRequest_no');
            $vendorId = Input::get('vendorId1');

            $itemNo = Input::get('itemNo1');
            $description = Input::get('description');
            $quantity = Input::get('quantity');
            $price = Input::get('price');
            $priceTax = Input::get('priceTax');
            $warranty = Input::get('warranty');
            $vendor = Input::get('vendor');

            $rowCountInfo = ProcurementItem::where('pRequest_no', '=', $pRequest_nos)->where('vendor_id', '=', $vendor)->get();
            $rowCount = $rowCountInfo->count();


            if ($quantity[0] == 0) {

                $requestedItems = ProcurementItem::where('pRequest_no', '=', $pRequest_nos)->get();
                $vendors = ProcurementItem::where('pRequest_no', '=', $pRequest_nos)->groupBy('vendor_id')->get();
                $procurementStatus = DB::table('procurement_status')->get();

                $viewRequests = ProcurementRequest::where('status', '=', 'On Process')->get();
                $requestStatus = ProcurementRequest::where('pRequest_no', '=', $pRequest_nos)->pluck('status');
                $users = DB::table('system_users')->get();

                \Session::flash('flash_message_CancelModification', 'No Modifications To Save');
                \Session::flash('flash_viewApprovalRequests', '');
                return view('Requests.Approval')->with('users', $users)->with('requestStatus', $requestStatus)->with('id', $pRequest_nos)->with('viewRequests', $viewRequests)->with('requestedItems', $requestedItems)->with('vendors', $vendors)->with('procurementStatus', $procurementStatus);

            }

            else {

                for ($a = 0; $a < $rowCount; $a++) {

                    $pRequest_noOne = $pRequest_no[$a];
                    $vendorIdOne = $vendorId[$a];
                    $itemNoOne = $itemNo[$a];
                    $descriptionOne = $description[$a];
                    $quantityOne = $quantity[$a];
                    $priceOne = $price[$a];
                    $priceTaxOne = $priceTax[$a];
                    $warrantyOne = $warranty[$a];
                    $totalPrice = $quantity[$a] * $price[$a];
                    $tax=$totalPrice + ($totalPrice*0.02);


                    $r = ProcurementItem::
                    where('pRequest_no', $pRequest_noOne)
                        ->where('vendor_id', $vendorIdOne)
                        ->where('item_no', $itemNoOne)
                        ->update(array('description' => $descriptionOne, 'quantity' => $quantityOne, 'price' => $priceOne, 'total_price' => $totalPrice, 'price_tax' => $tax, 'warranty' => $warrantyOne));
                }


                $requestedItems = ProcurementItem::where('pRequest_no', '=', $pRequest_nos)->get();
                $vendors = ProcurementItem::where('pRequest_no', '=', $pRequest_nos)->groupBy('vendor_id')->get();

                $users = DB::table('system_users')->get();

                $procurementStatus = DB::table('procurement_status')->get();
                $viewRequests = ProcurementRequest::where('status', '=', 'On Process')->get();
                $requestStatus = ProcurementRequest::where('pRequest_no', '=', $pRequest_nos)->pluck('status');


                \Session::flash('flash_message_savedChanges', 'Changes Have Been Saved');
                \Session::flash('flash_viewApprovalRequests', '');
                return view('Requests.Approval')->with('users', $users)->with('requestStatus', $requestStatus)->with('id', $pRequest_nos)->with('viewRequests', $viewRequests)->with('requestedItems', $requestedItems)->with('vendors', $vendors)->with('procurementStatus', $procurementStatus);

            }

        }
    }

    catch(\Exception $e)
    {
        return Redirect::back()->withErrors($e->getMessage());
    }


    }


 //------------------------------------Approve request based on selected conditions---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    Public function ApproveRequest(){

    try {

//   --------------Values from blade

        $pRequestNo = Input::get('vendorsRequestNo');
        $currentVendors = Input::get('currentVendors');
        $note = Input::get('note');
        $selectVendorId = Input::get('selectVendorId');
        $status = Input::get('status');

        $email1 = Input::get('email1');
        $email2 = Input::get('user');

        $noOfCc = sizeof($email2);
        $vendorsArraySize = sizeof($currentVendors);

//   -------------- Email From Address
        //$user_id = Auth::User()->employeeID;
        //$emailFromAddress = DB::table('system_users')->where('id', '=', $user_id)->pluck('email');

//  ---------------Query values

        $requestedItems = ProcurementItem::where('pRequest_no', '=',"")->get();
        $vendors = ProcurementItem::where('pRequest_no', '=', $pRequestNo)->groupBy('vendor_id')->get();

        $procurementStatus = DB::table('procurement_status')->get();
        $viewRequests = ProcurementRequest::where('status', '=', 'On Process')->get();


        $id ="-- Select Procurement Request --";
        $requestStatus = "";
        $requestPath = "";

// -------------Save to Note

        $createNote = new Note;
        $createNote->pRequest_no = $pRequestNo;
        $createNote->type_of_note = 1;
        $createNote->note = $note;
        $createNote->save();

// -----------check for conditions

        if ($status == "Approve" && $selectVendorId !='-- Select Vendor--') {

            if ($email1 != "--Approve--") {

                $userSeparate = explode('|', $email1);
                $userName = $userSeparate[0];
                $userId = $userSeparate[1];


                $emailAddress = $users = DB::table('system_users')->where('id', '=', $userId)->pluck('email');
                $dateToday = date('d-M-y');

                $UpdatePRequest = ProcurementRequest::where('pRequest_no', $pRequestNo)
                    ->update(array('status' => 'Approved'));

                $UpdateItems = ProcurementItem::where('pRequest_no', $pRequestNo)
                    ->where('vendor_id', $selectVendorId)
                    ->update(array('status' => 'Approved'));

                for ($a = 0; $a < $vendorsArraySize; $a++) {

                    if ($currentVendors[$a] != $selectVendorId) {
                        $UpdatePRequest = ProcurementItem::where('pRequest_no', $pRequestNo)
                            ->where('vendor_id', $currentVendors[$a])
                            ->update(array('status' => 'Rejected'));
                    }
                }

                Mail::send('Requests.ViewAllocatedResources', array('pRequestNo' => $pRequestNo, 'username' => $userName, 'date' => $dateToday, 'vendor' => $selectVendorId), function ($message) use ($userName, $emailAddress) {
                    // $message->from('srinithy.path@gmail.com');
                    $message->to($emailAddress, $userName)->subject('Procurement Request Has Been Approved');
                });

            }

            if ($noOfCc != 0) {

                for ($b = 0; $b < $noOfCc; $b++) {

                    $userSeparate = explode('|', $email2[$b]);
                    $userNameCc = $userSeparate[0];
                    $userIdCc = $userSeparate[1];
                    $emailAddressCc = $users = DB::table('system_users')->where('id', '=', $userIdCc)->pluck('email');
                    $dateToday = date('d-M-y');
                    $emails[$b] = $emailAddressCc;
                }

                Mail::send('Requests.ViewAllocatedResources', array('pRequestNo' => $pRequestNo, 'date' => $dateToday, 'vendor' => $selectVendorId), function ($message) use ($emails) {

                    for ($cc = 0; $cc < sizeof($emails); $cc++) {

                        $message->to($emails[$cc])->subject('Procurement Request Has Been Approved');
                    }

                });

            }
            $users = DB::table('system_users')->get();
            \Session::flash('flash_message', 'Procurement Request has been approved');

            return view('Requests.Approval')->with('users', $users)->with('requestPath', $requestPath)->with('id', $id)->with('requestStatus', $requestStatus)->with('viewRequests', $viewRequests)->with('procurementStatus', $procurementStatus)->with('requestedItems', $requestedItems)->with('vendors', $vendors);

        }

        elseif ($status == "On Hold") {

            $UpdatePRequest = ProcurementRequest::where('pRequest_no', $pRequestNo)
                ->update(array('status' => 'On Hold'));

            for ($a = 0; $a < $vendorsArraySize; $a++) {

                $UpdatePRequest = ProcurementItem::where('pRequest_no', $pRequestNo)
                    ->where('vendor_id', $vendors[$a])
                    ->update(array('status' => 'On Hold'));

            }

            $users = DB::table('system_users')->get();
            \Session::flash('flash_message', 'Procurement request has been saved as hold');

            return view('Requests.Approval')->with('users', $users)->with('requestPath', $requestPath)->with('id', $id)->with('requestStatus', $requestStatus)->with('viewRequests', $viewRequests)->with('procurementStatus', $procurementStatus)->with('requestedItems', $requestedItems)->with('vendors', $vendors);


        }

        elseif ($status == "Request More Details") {

            $UpdatePRequest = ProcurementRequest::where('pRequest_no', $pRequestNo)
                ->update(array('status' => 'Requested For Details'));

            $users = DB::table('system_users')->get();
            \Session::flash('flash_message', 'Procurement Status has been saved');

            return view('Requests.Approval')->with('users', $users)->with('requestPath', $requestPath)->with('id', $id)->with('requestStatus', $requestStatus)->with('viewRequests', $viewRequests)->with('procurementStatus', $procurementStatus)->with('requestedItems', $requestedItems)->with('vendors', $vendors);


        }

        elseif($status == "CC") {

            $UpdatePRequest = ProcurementRequest::where('pRequest_no', $pRequestNo)
                ->update(array('status' => 'CC'));

            if ($noOfCc != 0) {

                for ($b = 0; $b < $noOfCc; $b++) {

                    $userSeparate = explode('|', $email2[$b]);
                    $userNameCc = $userSeparate[0];
                    $userIdCc = $userSeparate[1];
                    $emailAddressCc = $users = DB::table('system_users')->where('id', '=', $userIdCc)->pluck('email');
                    $dateToday = date('d-M-y');
                    $emails[$b] = $emailAddressCc;
                }

                Mail::send('Requests.viewCCEmail', array('pRequestNo' => $pRequestNo, 'date' => $dateToday), function ($message) use ($emails) {

                    for ($cc = 0; $cc < sizeof($emails); $cc++) {

                        $message->to($emails[$cc])->subject('Clarifications On Procurement Request');
                    }

                });
            }

            $users = DB::table('system_users')->get();
            \Session::flash('flash_message', 'Procurement Status has been CCd');
            return view('Requests.Approval')->with('users', $users)->with('requestPath', $requestPath)->with('id', $id)->with('requestStatus', $requestStatus)->with('viewRequests', $viewRequests)->with('procurementStatus', $procurementStatus)->with('requestedItems', $requestedItems)->with('vendors', $vendors);


        }

        else
        {
            $users = DB::table('system_users')->get();
            \Session::flash('flash_message_CancelModification', 'Invalid vendor or invalid request status');
            return view('Requests.Approval')->with('users', $users)->with('requestPath', $requestPath)->with('id', $id)->with('requestStatus', $requestStatus)->with('viewRequests', $viewRequests)->with('procurementStatus', $procurementStatus)->with('requestedItems', $requestedItems)->with('vendors', $vendors);

        }

    }

    catch(\Exception $e)
    {
        return Redirect::back()->withErrors($e->getMessage());
    }

    }


//   --------------------------------------------Download attachment-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function getDownload($id){

    try {
        $pRequest_no = $id;
        $path = ProcurementRequest::where('pRequest_no', '=', $pRequest_no)->pluck('path');
        $fullPath = "C:/wamp/www/SEP" . $path;
        $filename = basename($path);
        $headers = array(
            'Content-Type: application/pdf',
            'Content-Type: application/zip',
            'Content-Type: application/rar',
            'Content-Type: application/jpeg',
            'Content-Type: application/png',
            'Content-Type: application/txt',

        );
        return Response::download($fullPath, $filename, $headers);
    }

    catch(\Exception $e)
    {

    }

    }




}

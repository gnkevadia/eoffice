<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Library\Common;
use App\Models\Booking;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class ApiController extends Controller {
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
	public function __construct()
    {   
        $this->objModel = new Booking;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function updateBookingStatus(Request $request) {
		global $apiResponseBody;
		try{
			if(isset($request->booking_id) && !empty($request->booking_id) && isset($request->order_status) && !empty($request->order_status)){
				$retriveOrderDetrails = $this->objModel->getBookingByOrderID($request->booking_id);
				if(isset($retriveOrderDetrails) && !empty($retriveOrderDetrails)){
					$this->objModel->updateOne($retriveOrderDetrails->id, array('status'=>$request->order_status));
					$arrResponse = array('status'=>1, 'message'=>"Status updated");
					return Common::apiJsonResponse($arrResponse, 200);
				}else{
					$arrResponse = array('status'=>0, 'message'=>"Status not updated");
					return Common::apiJsonResponse($arrResponse, 200);
				}

			}else{
				$arrResponse = array('status'=>0, 'message'=>"Something went wrong!");
				return Common::apiJsonResponse($arrResponse, 550);
			}
        }
        catch(Exception $e)
        {
			$arrResponse = ['status' => 'Error', 'status' => $e->getMessage(), 'data' => null];
			
			return Common::apiJsonResponse($arrResponse, 551);
        }
	}
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function rescheduleBooking(Request $request) {
		global $apiResponseBody;
		try{
			if(isset($request->booking_id) && !empty($request->booking_id) && isset($request->order_date) && !empty($request->order_date) && isset($request->reattempt_reason_text) && !empty($request->reattempt_reason_text) && isset($request->time_slot_id) && !empty($request->time_slot_id)){
				$retriveOrderDetrails = $this->objModel->getBookingByOrderID($request->booking_id);
				if(isset($retriveOrderDetrails) && !empty($retriveOrderDetrails)){
					if($request->time_slot_id == 1){
						$packageTime = "Morning (8:00 AM - 12:00 PM)";
					}elseif($request->time_slot_id == 2){
						$packageTime = "Noon (2:00 PM - 5:00 PM)";
					}elseif($request->time_slot_id == 3){
						$packageTime = "Evening (6:00 PM - 10:00 PM)";
					}elseif($request->time_slot_id == 4){
						$packageTime = "Mid Night (11:15 PM - 11:59 PM)";
					}
					$this->objModel->updateOne($retriveOrderDetrails->id, array('booking_date'=>date("Y-m-d", strtotime($request->order_date)), 'reson_for_rescheduled'=>$request->reattempt_reason_text, 'package_time'=>$packageTime));
					$arrResponse = array('status'=>1, 'message'=>"Order rescheduled");
					return Common::apiJsonResponse($arrResponse, 200);
				}else{
					$arrResponse = array('status'=>0, 'message'=>"Order not updated");
					return Common::apiJsonResponse($arrResponse, 200);
				}

			}else{
				$arrResponse = array('status'=>0, 'message'=>"Something went wrong!");
				return Common::apiJsonResponse($arrResponse, 550);
			}
        }
        catch(Exception $e)
        {
			$arrResponse = ['status' => 'Error', 'status' => $e->getMessage(), 'data' => null];
			
			return Common::apiJsonResponse($arrResponse, 551);
        }
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function fetchOrders(Request $request) {
		global $apiResponseBody;
		try{
			$fetchOrders = $this->objModel->getAllDetails();
			
			if(isset($fetchOrders) && !empty($fetchOrders)){
				foreach($fetchOrders as $keyOrder => $valOrder){
					$data[$keyOrder]['booking_id'] = $valOrder->order_number;
					$data[$keyOrder]['package_name'] = $valOrder->package_name;
					$data[$keyOrder]['person_name'] = $valOrder->guardian_name;
					$data[$keyOrder]['mobile_number'] = $valOrder->guardian_mobile;
					$data[$keyOrder]['email'] = $valOrder->guardian_email;
					$data[$keyOrder]['address'] = $valOrder->guardian_address;

					$data[$keyOrder]['city'] = $valOrder->city_name;
					$data[$keyOrder]['state'] = $valOrder->state_name;
					$data[$keyOrder]['zip_code'] = $valOrder->zip_code;
					
					$data[$keyOrder]['number_of_kids'] = $valOrder->kids;
					$data[$keyOrder]['special_message_for_kids'] = $valOrder->special_message;
					$data[$keyOrder]['instruction_to_agency'] = $valOrder->instruction_to_agency;
					$data[$keyOrder]['package_inclusion_kit'] = $valOrder->package_inclusion_kit;
					$data[$keyOrder]['special_instruction_to_santa'] = $valOrder->special_instruction_to_santa;

					$data[$keyOrder]['name_of_santa'] = $valOrder->santa_name;
					$santaContact = json_decode($valOrder->santa_contact, true);
					$data[$keyOrder]['email_of_santa'] = @reset($santaContact['email']);
					$data[$keyOrder]['mobile_number_of_santa'] = @reset($santaContact['phone']);
				}
				
				$arrResponse = array('status'=>1, 'message'=>"Order fetched", 'data' => $data);
				return Common::apiJsonResponse($arrResponse, 200);
			}else{
				$arrResponse = array('status'=>0, 'message'=>"Order not fetched");
				return Common::apiJsonResponse($arrResponse, 200);
			}
        }
        catch(Exception $e)
        {
			$arrResponse = ['status' => 'Error', 'status' => $e->getMessage(), 'data' => null];
			
			return Common::apiJsonResponse($arrResponse, 551);
        }
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function fetchRetailUsers(Request $request) {
		global $apiResponseBody;
		try{
			$fetchRetailUsers = $this->objModel->getAllUserDetails();

			if(isset($fetchRetailUsers) && !empty($fetchRetailUsers)){
				foreach($fetchRetailUsers as $keyOrder => $valOrder){
					$data[$keyOrder]['team_name'] = $valOrder->team_name;
					$data[$keyOrder]['superwiser_name'] = $valOrder->superwiser_name;
					$data[$keyOrder]['email'] = $valOrder->guardian_email;
					$data[$keyOrder]['password'] = $valOrder->superwiser_password;
					$data[$keyOrder]['start_date'] = $valOrder->start_date;

					$data[$keyOrder]['expiry_date'] = $valOrder->expiry_date;
					$data[$keyOrder]['mobile_number'] = $valOrder->guardian_mobile;
					$data[$keyOrder]['address'] = $valOrder->guardian_address;
					
					$data[$keyOrder]['city'] = $valOrder->city_name;
					$data[$keyOrder]['state'] = $valOrder->state_name;
					$data[$keyOrder]['zip_code'] = $valOrder->zip_code;
					$data[$keyOrder]['alternate_email'] = $valOrder->bill_email;
					$data[$keyOrder]['alternate_mobile_number'] = $valOrder->guardian_alt_mobile;
				}
				
				$arrResponse = array('status'=>1, 'message'=>"Users fetched", 'data' => $data);
				return Common::apiJsonResponse($arrResponse, 200);
			}else{
				$arrResponse = array('status'=>0, 'message'=>"Users not fetched");
				return Common::apiJsonResponse($arrResponse, 200);
			}
        }
        catch(Exception $e)
        {
			$arrResponse = ['status' => 'Error', 'status' => $e->getMessage(), 'data' => null];
			
			return Common::apiJsonResponse($arrResponse, 551);
        }
	}
}
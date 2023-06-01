<?php

/**
 * Booking Master Booking
 * Manage CRUD for the Booking
 *
 * @author ATL
 * @since Jan 2020
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Library\Common;
use Illuminate\Http\Request;
use Lang;
use App\Models\Users;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TerminalsExport;
use App\Models\Brand;
use App\Models\CustomReports;
use App\Models\Terminal;
use App\Models\Inventory;
use App\Models\States;use App\Models\BrandStatesStatistics;
use App\Models\Package;
use App\Models\Reports;
use Illuminate\Support\Facades\Storage;
use Mail;
use DB;
use Illuminate\Support\Arr;
use Validator;
use Session;
use PDF;

class BookingController extends Controller
{
	public function __construct()
	{
		$this->objModel = new Booking;
		Common::defineDynamicConstant('booking');
	}
	/**
	 * Default Method for the controller
	 * List of the Booking
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	 */
	public function index(Request $request)
	{
		return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
	}
	
	public function view(Request $request, $id = null)
	{
		$dbBooking = new Booking;
		$data = $dbBooking->where(['booking.id' => $id])->first();
		
		$dbCustomReports = new CustomReports();
		$customReports = $dbCustomReports->where(['custom_reports.deleted' => 0, 'custom_reports.cart_id' => $data->cart_id])->get();

		foreach ($customReports as $key => $value) {
			$checkBoxId = $value->custom_checkbox;			
			$terminalData[] = Terminal::where(['terminal.deleted' => 0, 'terminal.id' => $checkBoxId])->get();
		}
		$dbUsers = new Users();
		$UserObj = $dbUsers->where(['users.deleted' => 0, 'users.id' => $data->user_id])->first();
		
		if (isset($data) && !empty($data)) {
			return view(RENDER_URL . '.view', compact('data', 'id', 'UserObj','terminalData'));
		} else {
			return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
		}
	}

	public function toggleStatus(Request $request)
	{
		$dbInventory = new Inventory();
		$dbUsers = new Users();
		$dbCustomReports = new CustomReports();
		$dbTerminal = new Terminal();
		$dbStates = new States();
		$dbReports = new Reports();
		$dbBrand = new Brand();

		$data = $request->input();
		if ($data['optionId'] == 1) {
			if (!empty($data['optionId']) && !empty($data['cartId'] && !empty($data['userId']))) {
				$cartId 		= $data['cartId'];
				
				$reportDetails	= $dbReports->where(['reports.deleted' => 0, 'reports.cart_id' => $cartId])->first();
				$customReports 	= $dbCustomReports->where(['custom_reports.deleted' => 0, 'custom_reports.cart_id' => $cartId])->get();

				$userId 	= $data['userId'];
				$userData 	= $dbUsers->where(['users.deleted' => 0, 'users.id' => $userId])->first();
				foreach ($customReports as $key => $value) {
					$checkBoxId 	= $value->custom_checkbox;
					$terminalData[] = Terminal::select(["code", "zip_code", "terminal", "gas_brand", "store_address", "nos_of_pump", "unleaded", "midgrede", "diesel","rack_price_unleaded","rack_price_midgrade","rack_price_diesel","delivery_charges","jobber_charges","gas_tax","diesel_tax","margin_unleaded","margin_midgrade","margin_premium","margin_diesel"])->where(['terminal.deleted' => 0, 'terminal.id' => $checkBoxId])->get();
				}
				
				foreach ($terminalData as $inventoryValueKey => $inventoryValue) 
				{
					foreach ($inventoryValue as $inventoryDataKey => $inventoryData) 
					{
						$storeAddress = $inventoryData->store_address;
						$zipCode = $inventoryData->zip_code;
					}
					if(!empty($zipCode))
					{
						$selectInventoryData[] = Inventory::select(["year","states","zip_code","amount","gas_station","ga_amount"])->where(['zip_code' => $zipCode])->get();
						$selectBrandData[] = $dbTerminal->where(['zip_code' => $zipCode])->get();
						$storeAddress = explode(',', $storeAddress);						
						$state = trim($storeAddress[1]);
						$selectStatesData = $dbStates->where(['state_code' => $state])->get();
						$stateName[] = $selectStatesData[$inventoryDataKey]->states_name;
						$stateId[] = $selectStatesData[$inventoryDataKey]->id;
					} else {
						exit('Data not Available');
					}
				}
				
				foreach ($selectBrandData as $selectBrandDatakey => $selectBrandDataValue) 
				{
					foreach ($selectBrandDataValue as $key => $value) {
						$storeAddress = $value->store_address;
						$storeAddressExpload = explode(',', $storeAddress);						
						$state = trim($storeAddressExpload[1]);

						$selectStatesData = $dbStates->where(['state_code' => $state])->get();
						$stateId = $selectStatesData[0]->id;

						$brandName = trim($value->gas_brand);
						$selectBrandDataID = $dbBrand->where(['name' => $brandName])->get();
						$brandId = $selectBrandDataID[0]->id;
						
						$brandStateTotalData[] = DB::table('brand_states_statistics')->select(['total','brand.name', 'states.states_name'])
						->join('brand', 'brand_states_statistics.brand', '=', 'brand.id')
						->join('states', 'brand_states_statistics.states', '=', 'states.id')
						->where(['brand'=>$brandId, 'states'=>$stateId])
						->get();
					}
				}
				
				foreach ($stateName as $key => $stateName)  {
					$selectGasStationData[] = Inventory::select(["states","code_total","gas_station_total"])->where(['states'=> $stateName])->get();
				}

				foreach ($brandStateTotalData as $key => $value) { if(count($value) == 0){ unset($brandStateTotalData[$key]); } }
				foreach ($selectInventoryData as $key => $value) { if(count($value) == 0){ unset($selectInventoryData[$key]); } }
				foreach ($terminalData as $key => $value) { if(count($value) == 0){ unset($terminalData[$key]); } }
				foreach ($selectGasStationData as $key => $value) { if(count($value) == 0){ unset($selectGasStationData[$key]); } }
				
				$dbPackage = new Package();
				$packageDetails = $dbPackage->where(['package.deleted' => 0, 'package.id'=> $reportDetails->package_id])->first();
				
				$ReportFirstPage = array($packageDetails->name, $packageDetails->report_title, $reportDetails->report_title, $reportDetails->created_at->format('d-m-Y'), $reportDetails->id);
				$filename = $reportDetails->id . '.xlsx';

				Excel::store(new TerminalsExport($terminalData,$selectInventoryData,$selectGasStationData,$brandStateTotalData,$ReportFirstPage), $filename, 'export');
				Mail::send('email_template', [], function ($message) use ($userData, $filename, $terminalData, $selectInventoryData, $selectGasStationData, $brandStateTotalData, $ReportFirstPage) {
					$message->to($userData['email'])
						->subject('Thank you')
						->from(env('FROM_EMAIL'), env('FROM_SUBJECT'))
						->attach(Excel::download(new TerminalsExport($terminalData,$selectInventoryData,$selectGasStationData,$brandStateTotalData,$ReportFirstPage), $filename)->getFile(), ['as' => $filename]);
				});
				@unlink(storage_path('export\\'.$filename));
				
				$dbBooking  = new Booking();
				$dbBooking->where(['cart_id' => $cartId])->update(['status' => '1', 'order_confirm' => 'Accepted']);
			}
		}
		else{
			if (!empty($data['optionId']) && !empty($data['cartId'] && !empty($data['userId']))) {
				$cartId = $data['cartId'];
				
				$userId = $data['userId'];
				$dbUsers = new Users();
				$userData = $dbUsers->where(['users.deleted' => 0, 'users.id' => $userId])->first();

				Mail::send('email_template', [], function ($message) use ($userData) {
					$message->to($userData['email'])
						->subject('Rejected Your Request')
						->from('anand.atulyam@gmail.com', 'FuelTrend');
				});

				$dbBooking  = new Booking();
				$dbBooking->where(['cart_id' => $cartId])->update(['status' => '0', 'order_confirm' => 'Rejected']);
			}
		}
	}
}

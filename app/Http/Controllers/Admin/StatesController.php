<?php
/**
 * States Master States
 * Manage CRUD for the States
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\States;
use App\Models\Country;
use Validator;
use App\Library\Common;
use Session;
use Lang;
use DB;
class StatesController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new States;
        Common::defineDynamicConstant('state');
    }
	/**
	 * Default Method for the controller
	 * List of the States
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function index(Request $request){
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '');
    }
	/**
	 * Default Method for the controller
	 * List of the states
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function ajaxIndex(Request $request){
        $dbStates = new States;
        $recordsTotal = 0;
    	$strWhere = '';
    	if(isset($request->search['value']) && !empty($request->search['value'])){
    		$strWhere = ' AND ( states.name like "%'.$request->search['value'].'%" OR states.name like "%'.$request->search['value'].'%" OR (
							    CASE 
							        WHEN (states.status = 1) THEN "Active"
							        ELSE "Inactive"
							    END
							) like "%'.$request->search['value'].'%") ';
    	}
    	$arrSortKey = array('id','name','countryname','status');
    	$strOrder = 'states.`name` ASC';
    	if(isset($request->order[0]['dir']) && !empty($request->order[0]['dir'])){
    		$strOrder = ' '.$arrSortKey[$request->order[0]['column']].' '.$request->order[0]['dir'];
    	}
    	$cntstatesDetails = $dbStates->getAllCount($strWhere);
    	
    	if(isset($cntstatesDetails) && count($cntstatesDetails)){
    		$recordsTotal = $cntstatesDetails[0]->cntstates;
    	}
    	
    	$statesDetails= $dbStates->selectQuery($strWhere, $strOrder, $request->start, $request->length); 
    	echo json_encode(array("data"=>json_decode(json_encode($statesDetails)),"recordsFiltered"=>$recordsTotal,"recordsTotal"=>$recordsTotal));die;
    }
	/**
	 * Create States using this method
	 * Add setting
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function add(Request $request){
        
        $messages = [
            'states_name.required' => 'Please enter state name',
            'states_name.regex' => 'Please enter valid state name',
			'state_code.required' => 'Please enter state code'
        ];
        $regxvalidator = [
            'states_name' => 'required|regex:/^[a-zA-Z ]*$/',
            'state_code' => 'required'
        ];

        if ($request->isMethod('post')) {
			
			$statesData = $this->objModel->where(['states_name' => $request->input('states_name'), 'state_code' => $request->input('state_code')])->get();
			$count = count($statesData);
			if($count > 0) {
				Session::flash('message', 'States are already Available');
				Session::flash('alert-class', 'alert-danger');
			}
			else{
				return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
			}
        }
        return view(RENDER_URL . '.add');

    }
	/**
	 * Edit States using this method
	 * Update setting
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function edit(Request $request, $id = null)
	{
        $data = $this->objModel->getOne($id);
		
        if (isset($data) && !empty($data)) {
            $messages = [
				'states_name.required' => 'Please enter state name',
				'states_name.regex' => 'Please enter valid state name',
				'state_code.required' => 'Please enter state code'
			];
			$regxvalidator = [
				'states_name' => 'required|regex:/^[a-zA-Z ]*$/',
				'state_code' => 'required'
			];

            if ($request->isMethod('post') && isset($id) && !empty($id)) {
				$statesData = $this->objModel->where(['states_name' => $request->input('states_name'), 'state_code' => $request->input('state_code')])->get();
				$count = count($statesData);
				if($count > 0) {
					Session::flash('message', 'States are already Available');
					Session::flash('alert-class', 'alert-danger');
				}
				else{
					return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
				}
            }
            return view(RENDER_URL . '.edit', compact('data'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }

      
    }
	/**
	 * Delete States using this method
	 * Remove setting by checking dependancy
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function delete(Request $request){
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
	/**
	 * Get States using this method
	 * Fetch all states based on the country
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function getStates(Request $request){
        $dbStates = new States;
        $stateName = $dbStates->getFromCountryId($request->country_id);
        return response()->json($stateName,200);
    }
	/**
     * Toggle Inclusion using this method
     * Active/InActive inclusion status
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function toggleStatus(Request $request)
    {
        return Common::commanTogglePage($this->objModel, $request);
    }
}
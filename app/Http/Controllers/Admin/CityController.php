<?php
/**
 * City Master City
 * Manage CRUD for the City
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\States;
use App\Models\Country;
use Validator;
use App\Library\Common;
use Lang;
use Session;
use Excel;
use App\Exports\CityExport;

class CityController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new City;
        Common::defineDynamicConstant('city');
    }
	/**
	 * Default Method for the controller
	 * List of the City
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function index(Request $request){  
        $dbCountries = new Country;
        $countries = $dbCountries->getAll();
        $dbStates = new States;
        $states = $dbStates->getAll();
        
        $additionalParams = $countries;
        
        return Common::commanListPage($this->objModel, '', '', '', '', $request->is_globle, '', '', '');
    }
	/**
	 * Create City using this method
	 * Add setting
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function add(Request $request){
        $dbCountries = new Country;
        $countries = $dbCountries->getAll();
        $dbStates = new States;
        $states = $dbStates->getAll();
        
        $messages = [
            'name.required' => 'Please enter city name',
            'name.regex' => 'Please enter valid city name',
            'name.unique' => 'City name already exists',
            'country_id.required' => 'Please select country',
        ];
        $regxvalidator = [
            'name' => 'required|regex:/^[a-zA-Z ]*$/ | unique:city,name,1,deleted,country_id,'.$request->country_id,
            'country_id' => 'required',
        ];
        
        $arrExpect = $additopnalOperation = $arrFile=array();
        
        $request->merge(["cluster"=>json_encode($request->cluster),"area"=>json_encode($request->area)]);

        if ($request->isMethod('post')) {

            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile, $additopnalOperation,$arrExpect);
        }

        return view(RENDER_URL . '.add', compact('states','countries'));
    }
	/**
	 * Ajax State using this method
	 * Get list of state
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function stateajaxData(Request $request)
    {
        $dbStates  = new States;
        $statename = $dbStates->getStateByCountryId($request->countryId);
        return response()->json($statename);        
    }
	/**
	 * Edit City using this method
	 * Update setting
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function edit(Request $request, $id = null){
        $dbCountries = new Country;
        $countries = $dbCountries->getAll();
        $dbStates = new States;
        $states = $dbStates->getAll();
        
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please enter city name',
                'name.regex' => 'Please enter valid city name',
                'name.unique' => 'Country/City name already exists',
                'country_id.required' => 'Please select country',
            ];

            $regxvalidator = [

                'name' => 'required|regex:/^[a-zA-Z ]*$/ | unique:city,name,'.$data->id.',id,deleted,0,country_id,'.$request->country_id,
                'country_id' => 'required',
            ];

            $arrExpect = $additopnalOperation = $arrFile=array();
        
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL . '.edit', compact('data','countries','states'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
	 * View City using this method
	 * Read setting
	 *
	 * @param string $request 
	 * @param integer $id 
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function view(Request $request, $id = null){
        $dbCountries = new Country;
        $countries = $dbCountries->getAll();
        $dbStates = new States;
        $states = $dbStates->getAll();
        $dbCity = new City;
        $data = $dbCity->getOne($id);
        if(isset($data) && !empty($data)){
            return view(RENDER_URL . '.view', compact('data','countries','states'));
        }else{
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
	 * Copy City using this method
	 * Clone setting with suffix "copy" name
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function copy(Request $request){
        if ($request->isMethod('post')) {
            return Common::commanCopyPage($this->objModel, $request);
        }
    }
	/**
	 * Delete City using this method
	 * Remove city by checking dependancy
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
	/**
	 * Export City using this method
	 * export setting with all data
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function export(Request $request){
        
        return Excel::download(new CityExport, 'City.xlsx');
    }
    /**
	 * Export City using this method
	 * export setting with all data
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function getCities(Request $request){
        $data = $request->input();
        $dbCity = new City();
        $html = $orderby = '';
        
        if(isset($data['country_id']) && !empty($data['country_id'])) {
			$dynamicWhere = 'city.status = 1 AND city.country_id ='.$data['country_id'];
			
            $arrPackageList = $dbCity->getAll($orderby, $where=array(), $dynamicWhere);
            $html .= '<option value="">-Select-</option>';
			foreach($arrPackageList as $keyPackage=>$valPackage) {
                $explodeCity = explode(",",$request->city_id);
                if(isset($request->city_id) && !empty($request->city_id) && ($request->city_id == $valPackage->id || in_array($valPackage->id,$explodeCity)) ){
                    $html .= '<option value="'.$valPackage->id.'" selected>'.$valPackage->name.'</option>';
                }else{
                    $html .= '<option value="'.$valPackage->id.'">'.$valPackage->name.'</option>';
                }
            }			
            
			return $html;
		}
    }
    /**
	 * Export City using this method
	 * export setting with all data
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function getClusters(Request $request){
        $data = $request->input();
        $dbCity = new City();
        $html = $orderby = '';
        
        if(isset($data['city_id']) && !empty($data['city_id'])) {
            
            $cityDetails = $dbCity->getOne($data['city_id']);
            $clusters = json_decode($cityDetails->cluster);

            $html .= '<option value="">-Select-</option>';
            if(isset($clusters) && !empty($clusters)){
                foreach($clusters as $keyCluser=>$valCluser) {
                    $html .= '<option value="'.$valCluser.'">'.$valCluser.'</option>';
                }
            }
            
			return $html;
		}
    }
    /**
	 * Export City using this method
	 * export setting with all data
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function changeCity(Request $request){
        $data = $request->input();
        $html = $orderby = '';
        
        if(isset($data['current_city_id']) && !empty($data['current_city_id'])) {
            Session::put('current_city_id', $data['current_city_id']);
			
			return $html;
		}else{
            Session::forget('current_city_id');
        }
    }
}

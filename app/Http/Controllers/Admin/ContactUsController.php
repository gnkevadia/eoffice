<?php
/**
 * ContactUs Master ContactUs
 * Manage CRUD for the ContactUs
 *
 * @author ATL
 * @since Jan 2020
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Validator;
use App\Library\Common;
use Lang;
use Session;
use Excel;
use App\Exports\ContactUsExport;

class ContactUsController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new ContactUs;
        Common::defineDynamicConstant('contact-us');
    }
	/**
	 * Default Method for the controller
	 * List of the ContactUs
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
	 * View ContactUs using this method
	 * Read setting
	 *
	 * @param string $request 
	 * @param integer $id 
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function view(Request $request, $id = null){
        $dbContactUs = new ContactUs;
        $data = $dbContactUs->getOne($id);
        if(isset($data) && !empty($data)){
            return view(RENDER_URL . '.view', compact('data'));
        }else{
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
	 * Export ContactUs using this method
	 * export setting with all data
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function export(Request $request){
        
        return Excel::download(new ContactUsExport, 'ContactUs.xlsx');
    }
}

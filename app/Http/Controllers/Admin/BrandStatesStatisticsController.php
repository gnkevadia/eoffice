<?php
/**
 * BrandStatesStatistics Master BrandStatesStatistics
 * Manage CRUD for the BrandStatesStatistics
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\BrandStatesStatistics;
use App\Models\States;
use App\Models\Brand;
use App\Library\Common;
use Illuminate\Http\Request;
use Session;
use Lang;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\InventoryImport;


class BrandStatesStatisticsController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new BrandStatesStatistics;
        Common::defineDynamicConstant('brand-states-statistics');
    }
    /**
     * Default Method for the controller
     * List of the BrandStatesStatistics
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
    /**
     * Create BrandStatesStatistics using this method
     * Add BrandStatesStatistics
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbstates = new States;
        $states = $dbstates->get('states_name');    

        $dbbrand = new Brand();
        $brand = $dbbrand->get('name');
       
        $messages = [
            'brand.required' => 'Please specify brand',
            'states.required' => 'Please specify states',
            'total.unique' => 'Please specify total',
        ];
        
        $regxvalidator = [
            'brand' => 'required',
            'states' => 'required',
            'total' => 'required',
        ];

        if ($request->isMethod('post')) {

            $dbBrandStatesStatistics = new BrandStatesStatistics();
            $brandStatesStatisticsDetails = $dbBrandStatesStatistics->where(['brand' => $request->input('brand'), 'states' => $request->input('states')])->get();
            $count = count($brandStatesStatisticsDetails);
            if($count > 0) {
                Session::flash('message', 'Brand & States are already Available');
                Session::flash('alert-class', 'alert-danger');
            }   
            else{
                return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
            }
        }
        return view(RENDER_URL.'.add', compact('states', 'brand'));
    }
    /**
     * Edit BrandStatesStatistics using this method
     * Update BrandStatesStatistics
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $dbstates = new States;
        $states = $dbstates->get('states_name');

        $dbbrand = new Brand();
        $brand = $dbbrand->getAll('name');
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'brand.required' => 'Please specify brand',
                'states.required' => 'Please specify states',
                'total.unique' => 'Please specify total',
            ];

            $regxvalidator = [
                'brand' => 'required',
                'states' => 'required',
                'total' => 'required',
            ];
            
            if ($request->isMethod('post') && isset($id) && !empty($id)) 
            {
                $dbBrandStatesStatistics = new BrandStatesStatistics();
                $brandStatesStatisticsDetails = $dbBrandStatesStatistics->where(['brand' => $request->input('brand'), 'states' => $request->input('states')])->get();
                $count = count($brandStatesStatisticsDetails);
                if($count > 0) {
                    Session::flash('message', 'Brand & States are already Available');
                    Session::flash('alert-class', 'alert-danger');
                }
                else{
                    return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
                }
            }
            return view(RENDER_URL.'.edit', compact('data', 'states', 'brand'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete BrandStatesStatistics using this method
     * Remove brand-states-statistics by checking dependancy
     *
     * @param string $request
     *
     * @author ATL  
     * @since Jan 2020
     */
    public function delete(Request $request)
    {
        $arrTableFields = array(
            "categories"=>"parent_id",
        );
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
    /**
     * Toggle BrandStatesStatistics using this method
     * Active/InActive BrandStatesStatistics status
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

    public function import(Request $request)
    {
        $messages = [
            'file.required' => 'Please upload file',
            'file.mimes' => 'Invalid File Extension. The supported file extensions is .csv',
            'file.max' => 'File size should be less than 2 MB',
        ];
        $regxvalidator = [
            'file' => ['required','mimes:csv,txt,xlsx','max:2048'],
        ];

        if ($request->isMethod('post')) {
            $arrFile = array('name'=>'file','path'=>'import','predefine'=>'');
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $file_name = $arrFile['predefine']?$arrFile['predefine']:rand().time().'.'.$extension;
            $filePath  = public_path($arrFile['path']).'\\'.$file_name;

            if(in_array($extension,array('xlsx'))){
                $file->move(public_path($arrFile['path']), $file_name);
            }

            Excel::import(new InventoryImport,  $filePath);
            exit('OK');
            @unlink(public_path($arrFile['path']."/".$file_name));

        }
        return view(RENDER_URL.'.import');
    }
}

<?php
/**
 * Usp Master Usp
 * Manage CRUD for the Usp
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Usp;
use App\Library\Common;
use Illuminate\Http\Request;
use Lang;

class UspController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new Usp;
        Common::defineDynamicConstant('usp');
    }
    /**
     * Default Method for the controller
     * List of the Usp
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
     * Create Usp using this method
     * Add usp
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $dbDesignation = new Designation();
        $arrDesignation = $dbDesignation->getAll('name');
        $messages = [
                'name.required' => 'Please specify Member',
                'name.regex' => 'Member cannot have character other than a-z AND A-Z and special character.',
                'name.unique' => 'Member already exists',
                'image.required' => 'Please specify Photo Image',
                'image.mimes' => 'Invalid File Extension. The supported file extensions is .png',
                'image.max' => 'File size should be less than 1 MB',
                'order.required' => 'Please specify Order',
                'description.required' => 'Please specify Description'
            ];
        
        $regxvalidator = [
            'name' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/ | unique:usp,name',
                'image' => 'required|max:1024',
                'order' => 'required',
                'description' => 'required'
            ];
        $arrFile = array('name'=>'img','type'=>'image','resize'=>'16','path'=>'images/usp/', 'predefine'=>'', 'except'=>'image_exist');
        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL.'.add', compact('arrDesignation'));
    }
    /**
     * Edit Usp using this method
     * Update usp
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);
        $dbDesignation = new Designation();
        $arrDesignation = $dbDesignation->getAll('name');
        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify Usp',
                'name.regex' => 'Usp cannot have character other than a-z AND A-Z and special character.',
                'name.unique' => 'Usp already exists',
                'image.required' => 'Please specify Photo Image',
                'image.mimes' => 'Invalid File Extension. The supported file extensions is .png',
                'image.max' => 'File size should be less than 1 MB',
                'order.required' => 'Please specify Order',
                'description.required' => 'Please select Description'
            ];
        
        $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/ | unique:usp,name,'.$data->id.',id',
                'image' => 'required_if:id,null|max:1024',
                'order' => 'required',
                'description' => 'required'
            ];
            $arrFile = array('name'=>'img','type'=>'image','resize'=>'16','path'=>'images/usp/', 'predefine'=>'', 'except'=>'image_exist', 'existing'=>$data->img);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            return view(RENDER_URL.'.edit', compact('data','arrDesignation','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
	 * Delete USP using this method
	 * Remove usp by checking dependancy
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	*/
    public function delete(Request $request)
    {
		$arrTableFields = array();
        return Common::commanDeletePage($this->objModel, $request, $arrTableFields);
    }
    /**
     * Toggle Usp using this method
     * Active/InActive usp status
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

<?php
/**
 * Country Master Country
 * Manage CRUD for the Country
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Library\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Lang;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Country;
        Common::defineDynamicConstant('country');
    }
    /**
     * Default Method for the controller
     * List of the Country
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
     * Create Country using this method
     * Add country
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {

        $messages = [
            'nicename.required' => 'Please specify Country Name',
            'nicename.unique' => 'Country Name already exists',
            'nicename.regex' => 'Name cannot have character other than a-z AND A-Z',
            'iso.required' => 'Please specify Country Code',
            'iso.unique' => 'Country Code already exists',
            'iso.regex' => 'Country Code cannot have character other than a-z AND A-Z',
            'phonecode.required' => 'Please specify Phone Code',
            'phonecode.regex' => 'Phone Code cannot have character other than 0-9',
            'flag.required' => 'Please specify Flag Image',
            'flag.mimes' => 'Invalid File Extension. The supported file extensions is .png',
            'flag.max' => 'File size should be less than 1 MB',
        ];
        $regxvalidator = [
            'nicename' => 'required | regex:/^[a-zA-Z ]+$/ | unique:countries,nicename,1,deleted',
            'iso' => 'required | regex:/^[a-zA-Z ]+$/ | unique:countries,iso,1,deleted',
            'phonecode' => 'required|regex:/^[0-9]+$/',
            'flag' => 'required_if:id,null|max:2048|mimes:png'
        ];
        $arrFile = array('name'=>'flag_img','type'=>'image','resize'=>'16','path'=>'images/flags/', 'predefine'=>'', 'except'=>'flag_exist');
        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL . '.add');

    }
    /**
     * Edit Country using this method
     * Update country
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
                'nicename.required' => 'Please specify Country Name',
                'nicename.regex' => 'Name cannot have character other than a-z AND A-Z',
                'nicename.unique' => 'Country Name already exists',
                'iso.required' => 'Please specify Country Code',
                'iso.unique' => 'Country Code already exists',
                'iso.regex' => 'Country Code cannot have character other than a-z AND A-Z',
                'iso.unique' => 'Country Code already exists',
                'phonecode.required' => 'Please specify Phone Code',
                'phonecode.regex' => 'Country Code cannot have character other than 0-9',
                'flag_img.required' => 'Please specify Flag Image',
                'flag_img.mimes' => 'Invalid File Extension. The supported file extensions is .png',
                'flag_img.max' => 'File size should be less than 1 MB',
            ];
            
            $regxvalidator = [
                'nicename' => 'required | regex:/^[a-zA-Z ]+$/ | unique:countries,nicename,'.$data->id.',id,deleted,0',
                'iso' => 'required | regex:/^[a-zA-Z ]+$/ | unique:countries,iso,'.$data->id.',id,deleted,0',
                'phonecode' => 'required|regex:/^[0-9]+$/',
            ];
            $arrFile = array('name'=>'flag_img','type'=>'image','resize'=>'16','path'=>'images/flags/', 'predefine'=>'', 'except'=>'flag_exist', 'existing'=>$data->flag);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            return view(RENDER_URL . '.edit', compact('data','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
    /**
     * View Country using this method
     * View country
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function view(Request $request, $id = null)
    {
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $arrFile = array('name'=>'flag_img','type'=>'image','resize'=>'16','path'=>'images/flags/', 'predefine'=>'', 'except'=>'flag_exist', 'existing'=>$data->flag);

            return view(RENDER_URL . '.view', compact('data','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Country using this method
     * Remove country by checking dependancy
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
     * Toggle Country using this method
     * Active/InActive country status
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

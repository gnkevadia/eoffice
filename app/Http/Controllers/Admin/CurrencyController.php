<?php
/**
 * Currency Master Currency
 * Manage CRUD for the Currency
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Library\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Lang;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Currency;
        Common::defineDynamicConstant('currency');
    }
    /**
     * Default Method for the controller
     * List of the Currency
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
     * Create Currency using this method
     * Add currency
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $messages = [
            'name.required' => 'Please specify Currency Name',
            'flag.required' => 'Please specify Flag Image',
            'code.required' => 'Phone Code cannot have character other than 0-9',
        ];
        $regxvalidator = [
            'name' => 'required | regex:/^[a-zA-Z ]+$/ | unique:countries,nicename,1,deleted',
            'code' => 'required',
            'flag' => 'required_if:id,null|max:2048|mimes:png'
        ];
        $arrFile = array('name'=>'flag','type'=>'image','resize'=>'16','path'=>'images/flags/', 'predefine'=>'', 'except'=>'flag_exist');
        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL . '.add');

    }
    /**
     * Edit Currency using this method
     * Update currency
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
                'name.required' => 'Please specify Currency Name',
                'flag.required' => 'Please specify Flag Image',
                'code.required' => 'Phone Code cannot have character other than 0-9',
            ];
            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z ]+$/ | unique:countries,nicename,1,deleted',
                'code' => 'required',
                'flag' => 'required_if:id,null|max:2048|mimes:png'
            ];
            $arrFile = array('name'=>'flag','type'=>'image','resize'=>'16','path'=>'images/flags/', 'predefine'=>'', 'except'=>'flag_exist', 'existing'=>$data->flag);
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id, $arrFile);
            }
            return view(RENDER_URL . '.edit', compact('data','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
    /**
     * View Currency using this method
     * View currency
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
            $arrFile = array('name'=>'flag','type'=>'image','resize'=>'16','path'=>'images/flags/', 'predefine'=>'', 'except'=>'flag_exist', 'existing'=>$data->flag);

            return view(RENDER_URL . '.view', compact('data','arrFile'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Currency using this method
     * Remove currency by checking dependancy
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
     * Toggle Currency using this method
     * Active/InActive currency status
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

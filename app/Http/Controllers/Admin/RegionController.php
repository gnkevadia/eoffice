<?php
/**
 * Region Master Region
 * Manage CRUD for the Region
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Library\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Lang;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->objModel = new Region;
        Common::defineDynamicConstant('region');
    }
    /**
     * Default Method for the controller
     * List of the Region
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
     * Create Region using this method
     * Add region
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $messages = [
            'name.required' => 'Please specify Region Name',
        ];
        $regxvalidator = [
            'name' => 'required',
        ];
        $arrFile = array('name'=>'flag','type'=>'image','resize'=>'16','path'=>'images/flags/', 'predefine'=>'', 'except'=>'flag_exist');
        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator, $arrFile);
        }
        return view(RENDER_URL . '.add');

    }
    /**
     * Edit Region using this method
     * Update region
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
                'name.required' => 'Please specify Region Name',
            ];
            $regxvalidator = [
                'name' => 'required',
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
     * View Region using this method
     * View region
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
     * Delete Region using this method
     * Remove region by checking dependancy
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
     * Toggle Region using this method
     * Active/InActive region status
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

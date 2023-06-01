<?php
/**
 * Category Master Category
 * Manage CRUD for the Category
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Library\Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;

class CategoryController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new Category;
        Common::defineDynamicConstant('category');
    }
    /**
     * Default Method for the controller
     * List of the Category
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
     * Create Category using this method
     * Add Category
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $allcategory = Common::fetchCategoryTree();

        $messages = [
            'name.required' => 'Please specify name',
            'name.regex' => 'Name cannot have character other than a-z,A-Z,0-9 and special character',
            'name.unique' => 'name already exists',
            'ordering.required' => 'Please specify ordering',
            'ordering.numeric' => 'ordering cannot have character other than numeric',
            'ordering.max' => 'fbUserId cannot exceed more than 999.'
        ];
        
        $regxvalidator = [
               'name' => 'required |regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/ | unique:categories,name,1,deleted',
                'ordering' => 'required|numeric|max:999',
            ];

        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add', compact('allcategory'));
    }
    /**
     * Edit Category using this method
     * Update Category
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function edit(Request $request, $id = null)
    {
        $allcategory = Common::fetchCategoryTree();
        $data = $this->objModel->getOne($id);

        if (isset($data) && !empty($data)) {
            $messages = [
                'name.required' => 'Please specify name',
                'name.regex' => 'Name cannot have character other than a-z,A-Z,0-9 and special character',
                'name.unique' => 'name already exists',
                
            ];

            $regxvalidator = [
                'name' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/ | unique:categories,name,'.$request->id.',id,deleted,0',
                
            ];

            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data', 'allcategory'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Category using this method
     * Remove category by checking dependancy
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
     * Toggle Category using this method
     * Active/InActive Category status
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

<?php
/**
 * Faq Master Faq
 * Manage CRUD for the Faq
 *
 * @author ATL
 * @since Jan 2020
 */
namespace App\Http\Controllers\Admin;

use App\Exports\MainExport;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Library\Common;
use Excel;
use Illuminate\Http\Request;
use Session;
use Validator;
use Lang;

class FaqController extends Controller
{
    public function __construct()
    {   
        $this->objModel = new Faq;
        Common::defineDynamicConstant('faq');
    }
    /**
     * Default Method for the controller
     * List of the Faq
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
     * Create Faq using this method
     * Add faq
     *
     * @param string $request
     *
     * @author ATL
     * @since Jan 2020
     */
    public function add(Request $request)
    {
        $messages = [
                'question.required' => 'Please specify question',
                'question.regex' => 'question cannot have character other than a-z AND A-Z and special character.',
                'question.unique' => 'question already exists',
                'answer.required' => 'Please specify Answer',
                'ordering.numeric' => 'ordering cannot have character other than numeric',
            ];
        
        $regxvalidator = [
                'question' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/ | unique:faq,question,1,deleted',
                'answer' => 'required',
                'ordering' => 'numeric|nullable',
            ];
        if ($request->isMethod('post')) {
            return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
        }
        return view(RENDER_URL.'.add');
    }
    /**
     * Edit Faq using this method
     * Update faq
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
            'question.required' => 'Please specify question',
            'question.regex' => 'question cannot have character other than a-z AND A-Z and special character.',
            'question.unique' => 'question already exists',
            'answer.required' => 'Please specify Answer',
            'ordering.numeric' => 'ordering cannot have character other than numeric',
        ];

            $regxvalidator = [
            'question' => 'required | regex:/^[a-zA-Z0-9 ?!@#\$%\^\&*\)\(+=._-]*$/ | unique:faq,question,'.$request->id.',id,deleted,0',
            'answer' => 'required',
            'ordering' => 'numeric|nullable',
        ];
            if ($request->isMethod('post') && isset($id) && !empty($id)) {
                return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
            }
            return view(RENDER_URL.'.edit', compact('data'));
        } else {
            return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
        }
    }
	/**
     * Delete Faq using this method
     * Remove faq by checking dependancy
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
     * Toggle Faq using this method
     * Active/InActive faq status
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

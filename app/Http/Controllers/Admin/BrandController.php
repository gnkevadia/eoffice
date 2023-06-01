<?php

/**
 * Brand Master Brand
 * Manage CRUD for the Brand
 *
 * @author ATL
 * @since Jan 2020
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Country;
use Validator;
use App\Library\Common;
use Session;
use Lang;
use DB;
use Maatwebsite\Excel\Facades\Excel;


use App\Imports\BrandStatesStatisticsImport;


class BrandController extends Controller
{
	public function __construct()
	{
		$this->objModel = new Brand;
		Common::defineDynamicConstant('brand');
	}
	/**
	 * Default Method for the controller
	 * List of the Brand
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
	 * Default Method for the controller
	 * List of the states
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	 */
	public function ajaxIndex(Request $request)
	{
		$dbStates = new Brand;
		$recordsTotal = 0;
		$strWhere = '';
		if (isset($request->search['value']) && !empty($request->search['value'])) {
			$strWhere = ' AND ( states.name like "%' . $request->search['value'] . '%" OR states.name like "%' . $request->search['value'] . '%" OR (
							    CASE 
							        WHEN (states.status = 1) THEN "Active"
							        ELSE "Inactive"
							    END
							) like "%' . $request->search['value'] . '%") ';
		}
		$arrSortKey = array('id', 'name', 'countryname', 'status');
		$strOrder = 'states.`name` ASC';
		if (isset($request->order[0]['dir']) && !empty($request->order[0]['dir'])) {
			$strOrder = ' ' . $arrSortKey[$request->order[0]['column']] . ' ' . $request->order[0]['dir'];
		}
		$cntstatesDetails = $dbStates->getAllCount($strWhere);

		if (isset($cntstatesDetails) && count($cntstatesDetails)) {
			$recordsTotal = $cntstatesDetails[0]->cntstates;
		}

		$statesDetails = $dbStates->selectQuery($strWhere, $strOrder, $request->start, $request->length);
		echo json_encode(array("data" => json_decode(json_encode($statesDetails)), "recordsFiltered" => $recordsTotal, "recordsTotal" => $recordsTotal));
		die;
	}
	/**
	 * Create Brand using this method
	 * Add setting
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	 */
	public function add(Request $request)
	{
		$dbCountries = new Country;
		$countries = $dbCountries->getAll();

		$messages = [
			'name.required' => 'Please enter name',
			'name.regex' => 'Please enter valid name',
		];
		$regxvalidator = [
			'name' => 'required|regex:/^[a-zA-Z ]*$/',
		];
		if ($request->isMethod('post')) {
			return Common::commanAddPage($this->objModel, $request, $messages, $regxvalidator);
		}
		return view(RENDER_URL . '.add', compact('countries'));
	}
	/**
	 * Edit Brand using this method
	 * Update setting
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	 */
	public function edit(Request $request, $id = null)
	{
		$dbCountries = new Country;
		$countries = $dbCountries->getAll();
		$data = $this->objModel->getOne($id);

		if (isset($data) && !empty($data)) {
			$messages = [
				'name.required' => 'Please enter name',
				'name.regex' => 'Please enter valid name',
			];

			$regxvalidator = [
				'name' => 'required|regex:/^[a-zA-Z ]*$/',
			];

			if ($request->isMethod('post') && isset($id) && !empty($id)) {
				return Common::commanEditPage($this->objModel, $request, $messages, $regxvalidator, $id);
			}
			return view(RENDER_URL . '.edit', compact('data', 'countries'));
		} else {
			return redirect(URL)->with(FLASH_MESSAGE_ERROR, Lang::get(COMMON_MSG_INVALID_ARGUE));
		}
	}
	/**
	 * Delete Brand using this method
	 * Remove setting by checking dependancy
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
	 * Get Brand using this method
	 * Fetch all states based on the country
	 *
	 * @param string $request
	 *
	 * @author ATL
	 * @since Jan 2020
	 */
	// public function getStates(Request $request)
	// {
	// 	$dbStates = new Brand;
	// 	$stateName = $dbStates->getFromCountryId($request->country_id);
	// 	return response()->json($stateName, 200);
	// }
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

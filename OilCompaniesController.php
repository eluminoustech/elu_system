<?php

class OilCompaniesController extends \BaseController {

	/**
	 * Display a listing of oilcompanies
	 *
	 * @return Response
	 */
	public function index()
	{
	    $oilcompanies = OilCompany::all();

	    return View::make('pages.oil_companies.list', compact('oilcompanies'));
	}

	/**
	 * Show the form for creating a new oilcompany
	 *
	 * @return Response
	 */
	public function create()
	{
	    return View::make('pages.oil_companies.create');
	}

	

	/**
	 * Show the form for editing the specified oilcompany.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	    $oilcompany = OilCompany::find($id);

	    return View::make('pages.oil_companies.create', compact('oilcompany'));
	}

	/**
         * Create Or Update Oil Company
         */
        public function save() 
        {
            Input::merge(array_map('trim', Input::all()));
            $rules = array(
                'company_name' => 'required'
            );
            
            $messages = array(
              'company_name.required' => Lang::get('oil_companies.name_require')  
            );
            
            $validator = Validator::make(Input::all(), $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->WithInput();
            }
            $result = OilCompany::saveCompany();
            if($result == true) {
                return Redirect::to('oil-companies')->with('success', Lang::get('oil_companies.company_saved'));
            } else {
                return Redirect::back()->with('error', $result);
            }
            
        }

	/**
	 * Remove the specified oilcompany from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    OilCompany::destroy($id);

	    return Redirect::to('oil-companies')->with('success', Lang::get('oil_companies.company_deleted'));
	}

}

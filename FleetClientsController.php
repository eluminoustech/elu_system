<?php

class FleetClientsController extends \BaseController
{
    /**
     * Display a listing of clients.
     *
     * @return Response
     */
    public function index()
    {
        ##  Fetch FleetClients of Logged in user##
        $clients = FleetClient::all();

        return View::make('pages.fleets.clients.list', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('pages.fleets.clients.create');
    }

    /**
     * Handles both creating new client and updating an existing client.
     *
     * @return Response
     */
    public function save()
    {
        ## Form Validation ##
        Validator::extend('phone', function ($attribute, $value, $parameters) {
            if (preg_match('/^[0-9]+$/', $value)) {
                return true;
            } else {
                return false;
            }
        });

        ## Define Rules ##
        $rules = array(
            'site_name'       => 'required',
            'contact_person'  => 'required',
            'contact_type'    => 'required',
            'phone_number'    => 'required|phone',
            'cell_number'     => 'phone',
            'address'         => 'required',
            'town'            => 'required',
            'province'        => 'required',
            'postal_code'     => 'required',
            'office_distance' => 'required|numeric|min:0',
            'bill_rate' => 'required|numeric|min:0',
        );

        ## Define Error Message ##
        $message = array(
            'site_name.required'       => Lang::get('clients.site_require'),
            'contact_person.required'  => Lang::get('clients.contact_require'),
            'contact_type.required'    => Lang::get('clients.contact_type_require'),
            'phone_number.required'    => Lang::get('clients.phone_require'),
            'address.required'         => Lang::get('clients.address_require'),
            'town.required'            => Lang::get('clients.town_require'),
            'province.required'        => Lang::get('clients.province_require'),
            'postal_code.required'     => Lang::get('clients.postal_code_require'),
            'office_distance.required' => Lang::get('clients.office_distance_require'),
            'phone_number.phone'       => Lang::get('clients.phone_invalid'),
            'cell_number.phone'        => Lang::get('clients.cell_number_invalid'),
        );

        $validator = Validator::make(Input::all(), $rules, $message);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        ##------to create /update client-------##
        $result = FleetClient::saveClient();
        if ($result == true) {
            return Redirect::to('fleets/clients')
                ->with('success', Lang::get('clients.client_saved'));
        } else {
            return Redirect::back()
                ->with('error', $result);
        }
    }

    /**
     * Display the specified client.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $client = FleetClient::findOrFail($id);

        return View::make('pages.fleets.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $client = FleetClient::find($id);

        return View::make('pages.fleets.clients.create', compact('client'));
    }

    /**
     * Remove the specified client from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $result = FleetClient::destroy($id);
        if ($result == true) {
            return Redirect::to('fleets/clients')
                ->with('success', Lang::get('clients.client_delete'));
        } else {
            return Redirect::back()
                ->with('error', $result);
        }
    }
}

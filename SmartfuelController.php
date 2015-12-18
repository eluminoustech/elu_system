<?php

use Reports\POSStatus;

class SmartfuelController extends Controller {

    /**
     * Returns a json array of terminals belonging to a specific site
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableTerminals()
    {
        return Response::json(POSStatus::getAvailableTerminals());
    }

}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParticipationClass;

/**
 * ParticipationClassController
 * -----------------------
 * Controller to handle the participationClass api routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers\Api
 */
class ParticipationClassController extends Controller {

    /**
     * Gets the data of the specified participation class.
     *
     * @param ParticipationClass $participationClass
     *
     * @return \Illuminate\View\View
     */
    public function show(ParticipationClass $participationClass) {
        return response()->json($participationClass);
    }

}


<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;

/**
 * EventController
 * -----------------------
 * Controller to handle the event api routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers\Api
 */
class EventController extends Controller {


    /**
     * Gets the data of the specified event.
     *
     * @param Event $event
     *
     * @return \Illuminate\View\View
     */
    public function show(Event $event) {

        $event->load('organizer.user', 'participationClasses', 'sportType', 'participations', 'visits');

        return response()->json($event);
    }
}


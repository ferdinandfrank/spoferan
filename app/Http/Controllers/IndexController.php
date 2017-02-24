<?php

namespace App\Http\Controllers;

use App\Models\Event;

class IndexController extends Controller {

    /**
     * Shows the application's index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        $events = Event::with('organizer.user', 'participationClasses', 'sportType')->withCount('participations')->main()->open()->orderBy('start_date')->get();

        return view('index', compact('events'));
    }
}

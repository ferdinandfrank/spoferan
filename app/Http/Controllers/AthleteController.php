<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Http\Requests\AthleteCreateRequest;

/**
 * AthleteController
 * -----------------------
 * Controller to handle the athlete routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class AthleteController extends Controller {

    /**
     * Displays a listing of all the athletes.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('athlete.index');
    }

    /**
     * Displays the specified athlete.
     *
     * @param Athlete $athlete
     *
     * @return \Illuminate\View\View
     */
    public function show(Athlete $athlete) {
        if (\Gate::denies('view', $athlete)) {
            abort(404, 'Page not found.');
        }

        return view('athlete.show', compact('athlete'));
    }

}


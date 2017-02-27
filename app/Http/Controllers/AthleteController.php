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

    /**
     * Shows the form for creating a new athlete.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        if (\Gate::denies('create', Athlete::class)) {
            abort(404, 'Page not found.');
        }

        $athlete = new Athlete();
        $isEditPage = false;

        return view('athlete.edit', compact('athlete', 'isEditPage'));
    }

    /**
     * Shows the form for editing the specified athlete.
     *
     * @param Athlete $athlete
     *
     * @return \Illuminate\View\View
     */
    public function edit(Athlete $athlete) {
        if (\Gate::denies('update', $athlete)) {
            abort(404, 'Page not found.');
        }

        $isEditPage = true;

        return view('athlete.edit', compact('athlete', 'isEditPage'));
    }

    /**
     * Creates a new athlete with the data from the specified request and
     * stores the data in the database.
     *
     * @param  AthleteCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AthleteCreateRequest $request) {
        if (\Gate::denies('create', Athlete::class)) {
            abort(403);
        }

        $athlete = Athlete::create($request->all());

        return response()->json($athlete, empty($athlete) ? 500 : 200);
    }

    /**
     * Updates the specified athlete with the specified request data in the database.
     *
     * @param AthleteCreateRequest $request
     * @param Athlete $athlete
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AthleteCreateRequest $request, Athlete $athlete) {
        if (\Gate::denies('update', $athlete)) {
            abort(403);
        }

        if ($athlete->update($request->all())) {
            return response()->json($athlete);
        }

        return response()->json($athlete, 500);
    }

    /**
     * Removes the specified athlete from the database.
     *
     * @param  \App\Models\Athlete  $athlete
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Athlete $athlete) {
        if (\Gate::denies('delete', $athlete)) {
            abort(403);
        }

        if ($athlete->delete()) {
            return response()->json($athlete);
        }

        return response()->json($athlete, 500);
    }

}


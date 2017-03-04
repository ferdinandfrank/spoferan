<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participation;
use App\Http\Requests\ParticipationCreateRequest;

/**
 * ParticipationController
 * -----------------------
 * Controller to handle the participation routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class ParticipationController extends Controller {

    /**
     * Displays a listing of all the participations.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('participation.index');
    }

    /**
     * Displays the specified participation.
     *
     * @param Participation $participation
     *
     * @return \Illuminate\View\View
     */
    public function show(Participation $participation) {
        if (\Gate::denies('view', $participation)) {
            abort(404, 'Page not found.');
        }

        return view('participation.show', compact('participation'));
    }

    /**
     * Shows the form for creating a new participation.
     *
     * @param Event $event
     *
     * @return \Illuminate\View\View
     */
    public function create(Event $event) {
        if (\Gate::denies('create', Participation::class)) {
            return redirect()->route('login');
        }

        return view('participation.create', compact('event'));
    }

    /**
     * Shows the form for editing the specified participation.
     *
     * @param Participation $participation
     *
     * @return \Illuminate\View\View
     */
    public function edit(Participation $participation) {
        if (\Gate::denies('update', $participation)) {
            abort(404, 'Page not found.');
        }

        $isEditPage = true;

        return view('participation.edit', compact('participation', 'isEditPage'));
    }

    /**
     * Creates a new participation with the data from the specified request and
     * stores the data in the database.
     *
     * @param  ParticipationCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ParticipationCreateRequest $request) {
        if (\Gate::denies('create', Participation::class)) {
            abort(403);
        }

        $participation = Participation::create($request->all());

        return response()->json($participation, empty($participation) ? 500 : 200);
    }

    /**
     * Updates the specified participation with the specified request data in the database.
     *
     * @param ParticipationCreateRequest $request
     * @param Participation $participation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ParticipationCreateRequest $request, Participation $participation) {
        if (\Gate::denies('update', $participation)) {
            abort(403);
        }

        if ($participation->update($request->all())) {
            return response()->json($participation);
        }

        return response()->json($participation, 500);
    }

    /**
     * Removes the specified participation from the database.
     *
     * @param  \App\Models\Participation  $participation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Participation $participation) {
        if (\Gate::denies('delete', $participation)) {
            abort(403);
        }

        if ($participation->delete()) {
            return response()->json($participation);
        }

        return response()->json($participation, 500);
    }

}


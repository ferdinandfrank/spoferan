<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ParticipationClass;
use App\Http\Requests\ParticipationClassCreateRequest;

/**
 * ParticipationClassController
 * -----------------------
 * Controller to handle the participationClass routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class ParticipationClassController extends Controller {

    /**
     * Displays a listing of all the participationClasses.
     *
     * @param Event $event
     *
     * @return \Illuminate\View\View
     */
    public function index(Event $event) {
        $size = 'is-12';

        return view('participation_class.index', compact('event', 'size'));
    }

    /**
     * Displays the specified participationClass.
     *
     * @param ParticipationClass $participationClass
     *
     * @return \Illuminate\View\View
     */
    public function show(ParticipationClass $participationClass) {
        if (\Gate::denies('view', $participationClass)) {
            abort(404, 'Page not found.');
        }

        return view('participation_class.show', compact('participationClass'));
    }

    /**
     * Shows the form for creating a new participationClass.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        if (\Gate::denies('create', ParticipationClass::class)) {
            abort(404, 'Page not found.');
        }

        $participationClass = new ParticipationClass();
        $isEditPage = false;

        return view('participation_class.edit', compact('participationClass', 'isEditPage'));
    }

    /**
     * Shows the form for editing the specified participationClass.
     *
     * @param ParticipationClass $participationClass
     *
     * @return \Illuminate\View\View
     */
    public function edit(ParticipationClass $participationClass) {
        if (\Gate::denies('update', $participationClass)) {
            abort(404, 'Page not found.');
        }

        $isEditPage = true;

        return view('participation_class.edit', compact('participationClass', 'isEditPage'));
    }

    /**
     * Creates a new participationClass with the data from the specified request and
     * stores the data in the database.
     *
     * @param  ParticipationClassCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ParticipationClassCreateRequest $request) {
        if (\Gate::denies('create', ParticipationClass::class)) {
            abort(403);
        }

        $participationClass = ParticipationClass::create($request->all());

        return response()->json($participationClass, empty($participationClass) ? 500 : 200);
    }

    /**
     * Updates the specified participationClass with the specified request data in the database.
     *
     * @param ParticipationClassCreateRequest $request
     * @param ParticipationClass $participationClass
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ParticipationClassCreateRequest $request, ParticipationClass $participationClass) {
        if (\Gate::denies('update', $participationClass)) {
            abort(403);
        }

        if ($participationClass->update($request->all())) {
            return response()->json($participationClass);
        }

        return response()->json($participationClass, 500);
    }

    /**
     * Removes the specified participationClass from the database.
     *
     * @param  \App\Models\ParticipationClass  $participationClass
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ParticipationClass $participationClass) {
        if (\Gate::denies('delete', $participationClass)) {
            abort(403);
        }

        if ($participationClass->delete()) {
            return response()->json($participationClass);
        }

        return response()->json($participationClass, 500);
    }

}


<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventCreateRequest;

/**
 * EventController
 * -----------------------
 * Controller to handle the event routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class EventController extends Controller {

    /**
     * Displays a listing of all the events.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('event.index');
    }

    /**
     * Displays the specified event.
     *
     * @param Event $event
     *
     * @return \Illuminate\View\View
     */
    public function show(Event $event) {

        $event->load('organizer.user', 'participationClasses', 'sportType', 'participations', 'visits');

        return view('event.show', compact('event'));
    }

    /**
     * Shows the form for creating a new event.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        if (\Gate::denies('create', Event::class)) {
            abort(404, 'Page not found.');
        }

        $event = new Event();
        $isEditPage = false;

        return view('event.edit', compact('event', 'isEditPage'));
    }

    /**
     * Shows the form for editing the specified event.
     *
     * @param Event $event
     *
     * @return \Illuminate\View\View
     */
    public function edit(Event $event) {
        if (\Gate::denies('update', $event)) {
            abort(404, 'Page not found.');
        }

        $isEditPage = true;

        return view('event.edit', compact('event', 'isEditPage'));
    }

    /**
     * Creates a new event with the data from the specified request and
     * stores the data in the database.
     *
     * @param  EventCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventCreateRequest $request) {
        if (\Gate::denies('create', Event::class)) {
            abort(403);
        }

        $event = Event::create($request->all());

        return response()->json($event, empty($event) ? 500 : 200);
    }

    /**
     * Updates the specified event with the specified request data in the database.
     *
     * @param EventCreateRequest $request
     * @param Event $event
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EventCreateRequest $request, Event $event) {
        if (\Gate::denies('update', $event)) {
            abort(403);
        }

        if ($event->update($request->all())) {
            return response()->json($event);
        }

        return response()->json($event, 500);
    }

    /**
     * Removes the specified event from the database.
     *
     * @param  \App\Models\Event  $event
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Event $event) {
        if (\Gate::denies('delete', $event)) {
            abort(403);
        }

        if ($event->delete()) {
            return response()->json($event);
        }

        return response()->json($event, 500);
    }

}


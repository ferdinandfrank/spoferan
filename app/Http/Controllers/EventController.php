<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventCreateRequest;
use DB;
use Illuminate\Http\Request;
use Log;

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
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $events = Event::search($request->all())->published()->main()->latest()->get();

        if ($request->ajax()) {
            return view('event.preview_list', compact('events'));
        }

        return view('event.index', compact('events'));
    }

    /**
     * Displays the specified event.
     *
     * @param Event $event
     *
     * @return \Illuminate\View\View
     */
    public function show(Event $event) {

        if ($event->isChild()) {
            return redirect()->action('EventController@showChild', ['event' => $event->parentEvent, 'child' => $event]);
        }

        $event->load('organizer.user', 'sportType', 'participations', 'visits');

        $goodParticipationClasses =
            \Gate::allows('participate', $event) ? $event->participationClasses()->canParticipate()->get() : collect();
        $participationClasses =
            $event->participationClasses()->ignore($goodParticipationClasses->pluck('id')->toArray())->get();

        $goodVisitClasses = \Gate::allows('visit', $event) ? $event->visitClasses()->canVisit()->get() : collect();
        $visitClasses = $event->visitClasses()->ignore($goodVisitClasses->pluck('id')->toArray())->get();

        return view('event.show',
            compact('event', 'goodParticipationClasses', 'participationClasses', 'goodVisitClasses', 'visitClasses'));
    }

    /**
     * Displays the specified child event.
     *
     * @param Event $event
     * @param Event $child
     *
     * @return \Illuminate\View\View
     */
    public function showChild(Event $event, Event $child) {
        $child->load('organizer.user', 'sportType', 'participations', 'visits');

        $goodParticipationClasses =
            \Gate::allows('participate', $child) ? $child->participationClasses()->canParticipate()->get() : collect();
        $participationClasses =
            $child->participationClasses()->ignore($goodParticipationClasses->pluck('id')->toArray())->get();

        $goodVisitClasses = \Gate::allows('visit', $child) ? $child->visitClasses()->canVisit()->get() : collect();
        $visitClasses = $child->visitClasses()->ignore($goodVisitClasses->pluck('id')->toArray())->get();

        return view('event.show', [
            'event'                    => $child,
            'goodParticipationClasses' => $goodParticipationClasses,
            'participationClasses'     => $participationClasses,
            'goodVisitClasses'         => $goodVisitClasses,
            'visitClasses'             => $visitClasses
        ]);
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
     *
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
     * @param Event              $event
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
     * @param  \App\Models\Event $event
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


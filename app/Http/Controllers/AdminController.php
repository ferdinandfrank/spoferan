<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\AdminCreateRequest;

/**
 * AdminController
 * -----------------------
 * Controller to handle the admin routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class AdminController extends Controller {

    /**
     * Displays a listing of all the admins.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('admin.index');
    }

    /**
     * Displays the specified admin.
     *
     * @param Admin $admin
     *
     * @return \Illuminate\View\View
     */
    public function show(Admin $admin) {
        if (\Gate::denies('view', $admin)) {
            abort(404, 'Page not found.');
        }

        return view('admin.show', compact('admin'));
    }

    /**
     * Shows the form for creating a new admin.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        if (\Gate::denies('create', Admin::class)) {
            abort(404, 'Page not found.');
        }

        $admin = new Admin();
        $isEditPage = false;

        return view('admin.edit', compact('admin', 'isEditPage'));
    }

    /**
     * Shows the form for editing the specified admin.
     *
     * @param Admin $admin
     *
     * @return \Illuminate\View\View
     */
    public function edit(Admin $admin) {
        if (\Gate::denies('update', $admin)) {
            abort(404, 'Page not found.');
        }

        $isEditPage = true;

        return view('admin.edit', compact('admin', 'isEditPage'));
    }

    /**
     * Creates a new admin with the data from the specified request and
     * stores the data in the database.
     *
     * @param  AdminCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminCreateRequest $request) {
        if (\Gate::denies('create', Admin::class)) {
            abort(403);
        }

        $admin = Admin::create($request->all());

        return response()->json($admin, empty($admin) ? 500 : 200);
    }

    /**
     * Updates the specified admin with the specified request data in the database.
     *
     * @param AdminCreateRequest $request
     * @param Admin $admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminCreateRequest $request, Admin $admin) {
        if (\Gate::denies('update', $admin)) {
            abort(403);
        }

        if ($admin->update($request->all())) {
            return response()->json($admin);
        }

        return response()->json($admin, 500);
    }

    /**
     * Removes the specified admin from the database.
     *
     * @param  \App\Models\Admin  $admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Admin $admin) {
        if (\Gate::denies('delete', $admin)) {
            abort(403);
        }

        if ($admin->delete()) {
            return response()->json($admin);
        }

        return response()->json($admin, 500);
    }

}


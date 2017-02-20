<?php

namespace App\Http\Controllers;

class IndexController extends Controller {

    /**
     * Shows the application's index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('index');
    }
}

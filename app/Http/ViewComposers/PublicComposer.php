<?php

namespace App\Http\ViewComposers;

use Carbon\Carbon;
use Illuminate\View\View;

/**
 * PublicComposer
 * -----------------------
 * ${CARET}
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\ViewComposers
 */
class PublicComposer {

    /**
     * Binds the necessary data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view) {
        $view->with('loggedUser', \Auth::user());
        $view->with('now', Carbon::now());
    }
}
<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

abstract class Page extends BasePage {

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements() {
        return [
            '@user-nav'      => '#user-nav',
            '@logout-button' => '#logout-button',
            '@navbar'        => '#navbar',
        ];
    }

    /**
     * Logs out the current user.
     *
     * @param Browser $browser
     */
    public function executeLogout(Browser $browser) {
        $browser->click('@user-nav');
        $browser->click('@logout-button');
    }
}

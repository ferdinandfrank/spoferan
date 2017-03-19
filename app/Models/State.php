<?php

namespace App\Models;

class State {

    protected static $states = [
        "DE" => [
            "DE-BW",
            "DE-BY",
            "DE-BE",
            "DE-BR",
            "DE-HB",
            "DE-HH",
            "DE-HE",
            "DE-MV",
            "DE-NI",
            "DE-NW",
            "DE-RP",
            "DE-SL",
            "DE-SN",
            "DE-ST",
            "DE-SH",
            "DE-TH",
        ]
    ];

    /**
     * Gets all the states.
     *
     * @return array
     */
    public static function all() {
        return static::$states;
    }

}
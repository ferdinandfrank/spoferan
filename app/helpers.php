<?php

/**
 * Checks if the current path is the path of the specified key's route.
 *
 * @param string $routeKey The key of the route to check.
 * @param bool   $recursive {@code false} if also child routes shall be checked
 *
 * @return bool if the current path is equal to the specified key's route.
 * if the current path is equal to the specified key's route.
 */
function isRoute($routeKey, $recursive = false) {
    $routeValue = route($routeKey);
    $currentRoute = Request::url();
    if (!$recursive) {
        return $routeValue === $currentRoute;
    }

    return substr($currentRoute, 0, strlen($routeValue)) === $routeValue;
}

/**
 * Gets the relative path of the specified route.
 *
 * @param string $route
 *
 * @return string
 */
function getRelativeRoute($route) {
    $currentUrl = url()->current();
    if (substr($route, 0, strlen($currentUrl)) == $currentUrl) {
        $route = substr($route, strlen($currentUrl));
    }

    if (substr($route, 0, 1) != '/') {
        $route = '/' . $route;
    }

    return $route;
}

/**
 * Formats the specified amount of cents to a localized money string.
 *
 * @param $cents
 *
 * @return string
 */
function formatMoney($cents) {
    $fmt = new NumberFormatter( 'de_DE', NumberFormatter::CURRENCY );
    return $fmt->formatCurrency($cents / 100, "EUR");
}

/**
 * Gets the diff for humans if the specified date is in the range of one day from today, otherwise the localized date.
 *
 * @param \Carbon\Carbon $date
 * @param bool           $withTime
 *
 * @return \Illuminate\Contracts\Translation\Translator|string
 */
function dateDiffForHumans(\Carbon\Carbon $date, $withTime = true) {
    $formattedDate = $date->formatLocalized('%d %b %Y');
    if ($date->isToday() || $date->isTomorrow() || $date->isYesterday()) {
        $formattedDate = $date->diffForHumans();

        // Only the hours or minutes are shown if the date is very close, so remove the extra time
        $withTime = false;
    }

    return $withTime ? trans('param_label.date_at_time', ['date' => $formattedDate, 'time' => $date->formatLocalized('%H:%M')]) : $formattedDate;
}

/**
 * Gets the color class of the specified participation's status.
 *
 * @param \App\Models\Participation $participation
 *
 * @return string
 */
function getParticipationStatusClass(\App\Models\Participation $participation) {
    $class = '';
    $status = $participation->status->label;
    switch ($status) {
        case 'registered':
            $class = 'is-success';
            break;
        case 'unregistered':
            $class = 'is-danger';
            break;
        case 'ranked':
            $class = 'is-success';
            break;
    }

    return $class;
}

/**
 * Appends the specified query params to the specified route.
 *
 * @param       $route
 * @param array $queryParams
 *
 * @return string
 */
function queryRoute($route, array $queryParams) {
    $numOfParams = 0;
    foreach ($queryParams as $key => $value) {
        $prefix = $numOfParams == 0 ? '?' : '&';
        $route .= $prefix . $key . "=" . $value;
        $numOfParams++;
    }

    return $route;
}

function calculateCCFee($cents) {
    $fullAmount = ($cents + intval(Settings::stripeCCFeeAmount())) / (1 - floatval(Settings::stripeCCFeePercent()));
    return round($fullAmount - $cents);
}
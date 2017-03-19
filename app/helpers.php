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
 * Gets the diff for humans if the specified date is in the range of one day from today, otherwise the localized date.
 *
 * @param \Carbon\Carbon $date
 * @param bool           $withTime
 *
 * @return \Illuminate\Contracts\Translation\Translator|string
 */
function dateDiffForHumans(\Carbon\Carbon $date, $withTime = true) {
    $formattedDate = $date->formatLocalized('%d %B %Y');
    if ($date->isToday() || $date->isTomorrow() || $date->isYesterday()) {
        $formattedDate = $date->diffForHumans();
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
    }

    return $class;
}

/**
 * Translate an amount of cents to a full decimal amount.
 *
 * @param $centsAmount
 *
 * @return string
 */
function translateCents($centsAmount) {
    $amount = 0;
    $centsAmount = strval($centsAmount);
    if (strlen($centsAmount) >= 3) {
        $amount = substr($centsAmount, 0, -2);
    }

    return $amount . ',' . substr($centsAmount, -2);
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
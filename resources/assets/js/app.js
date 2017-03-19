require('./config');

/***********************************************************
 Load JQuery
 --------------------------

 ************************************************************/
window.$ = window.jQuery = require('jquery');
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': Laravel.csrfToken}
});

/***********************************************************
 Load JQueryUI
 --------------------------

 ************************************************************/
require('./vendor/jquery-ui.min');

/***********************************************************
 Load Moment
 --------------------------
 Moment is a javascript library that we can use to format dates
 It's similar to Carbon in PHP so we mostly use it to format
 dates that are returned from our Laravel Eloquent models
 ************************************************************/
window.moment = require('moment');

/**
 * Load Select2
 */
require('./vendor/select2/select2');

/**
 * Load DateTimePicker
 */
require('./vendor/datetimepicker');

/***********************************************************
 Load Perfect Scrollbar
 --------------------------

 ************************************************************/
window.perfectScrollbar = require('perfect-scrollbar');
require('perfect-scrollbar/jquery')($);


/***********************************************************
 Load Gumshoe Scrollspy
 --------------------------

 ************************************************************/
window.gumshoe = require('gumshoe');

/***********************************************************
 Load SmoothScroll
 --------------------------

 ************************************************************/
window.smoothScroll = require('smooth-scroll');


window.theiaStickySidebar = require('theia-sticky-sidebar');

/***********************************************************
 Load VueJS
 --------------------------
 Vue is a modern JavaScript library for building interactive web interfaces
 using reactive data binding and reusable components. Vue's API is clean
 and simple, leaving you to focus on building your next great project.
 ************************************************************/
require('./vueInit');

require('./helper');

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

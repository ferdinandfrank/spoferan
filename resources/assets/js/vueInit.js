/***********************************************************
 VueJS
 --------------------------
 Vue is a modern JavaScript library for building interactive web interfaces
 using reactive data binding and reusable components. Vue's API is clean
 and simple, leaving you to focus on building your next great project.
 ************************************************************/
window.Vue = require('vue');
require('vue-resource');
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});

import dropdown from "./components/Dropdown.vue";
Vue.component('dropdown', dropdown);

import collapsibleCard from "./components/CollapsibleCard.vue";
Vue.component('collapsible-card', collapsibleCard);

import scrollspyList from "./components/ScrollspyList.vue";
Vue.component('scrollspy-list', scrollspyList);

import wizard from "./components/Wizard.vue";
Vue.component('wizard', wizard);

window.VueModel = Vue.extend({

    data() {
        return {
            // States if the notifications have already been marked as read
            notificationsMarked: false
        }
    },

    mounted() {
        let scrollBarElements = $('.scroll');
        if (scrollBarElements.length) {
            scrollBarElements.perfectScrollbar();
        }
    },

    methods: {
        markNotifications: function () {
            if (!this.notificationsMarked) {
                sendRequest('/users/notifications', 'DELETE', null, () => {
                    this.notificationsMarked = true;
                });
            }
        },

        toggleNavbar: function () {
            $('.navbar .nav-menu').toggleClass('is-active');
        }
    }
});

/**
 * If it doesn't already exist, register a separate empty vue instance that
 * is attached to the window, we can use it to listen out for and handle
 * any events that may emitted by components...
 */
if (!window.eventHub) {
    window.eventHub = new Vue();
}

// Vue production settings
// Vue.config.devtools = false;
// Vue.config.debug = false;
// Vue.config.silent = true;
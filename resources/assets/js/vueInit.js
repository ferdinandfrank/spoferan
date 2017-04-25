/***********************************************************
 VueJS
 --------------------------
 Vue is a modern JavaScript library for building interactive web interfaces
 using reactive data binding and reusable components. Vue's API is clean
 and simple, leaving you to focus on building your next great project.
 ************************************************************/
window.Vue = require('vue');
require('./../vendor/vue-forms/js/vue-forms');
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

import stripeForm from "./components/StripeForm.vue";
Vue.component('stripe-form', stripeForm);

import modalForm from "./components/ModalForm.vue";
Vue.component('modal-form', modalForm);

import slider from './components/Slider.vue';
Vue.component('slider', slider);

import messageBox from './components/MessageBox.vue';
Vue.component('message-box', messageBox);

window.VueModel = Vue.extend({
    i18n,

    data() {
        return {
            // States if the notifications have already been marked as read
            notificationsMarked: false,
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
        },
        
        emit: function () {
            let argsArray = Array.prototype.slice.call(arguments);
            window.eventHub.$emit.apply(window.eventHub, argsArray);
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
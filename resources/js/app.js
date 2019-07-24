/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Swal = require('sweetalert2');
window.Toast = window.Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

import VueI18n from 'vue-i18n';
Vue.use(VueI18n);

function loadLocaleMessages () {
    const locales = require.context('../lang/vue-i18n', true, /[A-Za-z0-9-_,\s]+\.json$/i);
    const messages = {};
    locales.keys().forEach(key => {
        const matched = key.match(/([A-Za-z0-9-_]+)\./i);
        if (matched && matched.length > 1) {
            const locale = matched[1];
            messages[locale] = locales(key);
        }
    });
    console.log(messages);
    return messages;
}

const numberFormats = {
    'en': {
        currency: {
            style: 'currency', currency: 'USD'
        }
    },
    'ptbr': {
        currency: {
            style: 'currency', currency: 'BRL', currencyDisplay: 'symbol'
        }
    }
};

const dateTimeFormats = {
    'en': {
        tiny: {
            month: 'numeric', day: 'numeric'
        },
        short: {
            year: 'numeric', month: 'short', day: 'numeric'
        },
        long: {
            year: 'numeric', month: 'short', day: 'numeric',
            weekday: 'short', hour: 'numeric', minute: 'numeric'
        }
    },
    'ptbr': {
        short: {
            year: 'numeric', month: 'short', day: 'numeric'
        },
        long: {
            year: 'numeric', month: 'short', day: 'numeric',
            weekday: 'short', hour: 'numeric', minute: 'numeric', hour12: true
        }
    }
};

// Create VueI18n instance with options
const i18n = new VueI18n({
    availableLocales: ['en', 'ptbr'],
    locale: app_language || 'en', // set locale
    fallbackLocale: process.env.MIX_VUE_APP_I18N_FALLBACK_LOCALE || 'en',
    messages: loadLocaleMessages(), // set locale messages
    numberFormats, // set locale currency formatting
    dateTimeFormats, // set locale date and time formatting
});



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('medicines-component', require('./components/MedicinesComponent.vue').default);
Vue.component('user-settings', require('./components/UserSettingsComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const vm = new Vue({
    i18n,
    data: function () {
        return {
            availableLanguages: [
                {code: 'en', label: 'English'},
                {code: 'ptbr', label: 'Português (BR)'},
            ],
        }
    }
}).$mount('#app');

/*Swal.fire({
    title: 'Error!',
    text: 'Do you want to continue',
    type: 'error',
    confirmButtonText: 'Cool'
});*/


/*window.axios.get('/api/medicine').then(data => {
    console.log(data);
});*/


import messages from './../../../js/locales';
let supportedLocales = ['de']; // Set the locales which the app supports

import VueI18n from "vue-i18n";
Vue.use(VueI18n);

// Read the current locale from the url
let locale = window.location.pathname.split('/')[1];
if (locale === null || supportedLocales.indexOf(locale) < 0) {
    locale = supportedLocales[0];
}

// Set the locale for the vue instance
window.i18n = new VueI18n({
    locale: locale,
    fallbackLocale: 'de',
    messages
});
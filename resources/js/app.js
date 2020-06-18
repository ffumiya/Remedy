/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import SkywayRoom from "./components/SkywayRoom.vue";
import FullCalendarComponent from "./components/CalendarComponent.vue";
import ReservationComponent from "./components/ReservationComponent.vue";
import DoctorHomeComponent from "./components/DoctorHomeComponent.vue";
import PatientHomeComponent from "./components/PatientHomeComponent.vue";
import StripeComponent from "./components/StripeComponent.vue";

import router from "./router";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("video-component", SkywayRoom);
Vue.component("calendar-component", FullCalendarComponent);
Vue.component("reservation-component", ReservationComponent);
Vue.component("doctor-home-component", DoctorHomeComponent);
Vue.component("patient-home-component", PatientHomeComponent);
Vue.component("stripe-component", StripeComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    router
});

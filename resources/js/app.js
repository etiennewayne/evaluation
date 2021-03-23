/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue').default;

window.axios = require('axios');

import Vue from 'vue'
//import VueRouter from 'vue-router'
import Buefy from 'buefy'

//import 'buefy/dist/buefy.css'



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('csrf', require('./components/Csrf.vue').default);

Vue.component('nav-bar', require('./components/administrator/Navbar.vue').default);

Vue.component('login-page', require('./components/LoginPage.vue').default);
Vue.component('welcome-page', require('./components/WelcomePage.vue').default);



//STUDENT
Vue.component('student-navbar-auth', require('./components/student/StudentNavbarAuth.vue').default);
Vue.component('student-navbar', require('./components/student/StudentNavbar.vue').default);
Vue.component('student-home', require('./components/student/StudentHome.vue').default);
Vue.component('schedule-page', require('./components/student/SchedulePage.vue').default);
Vue.component('criteria-page', require('./components/student/CriteriaPage.vue').default);
Vue.component('view-rating', require('./components/student/ViewRating.vue').default);


Vue.component('academic-year', require('./components/administrator/academicyear/AcademicYear.vue').default);
Vue.component('category', require('./components/administrator/category/Category').default);


//ADMINISTRATOR
Vue.component('panel-login-page', require('./components/administrator/PanelLoginPage.vue').default);




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(Buefy);
Vue.filter('formatTime', function(value) {
    // if (value) {
    //     const parts = value.split(":");
    //     return +parts[0] + "h " + +parts[1] + "m";
    // } else {
    //     return "unknown"
    // }
    // Check correct time format and split into components
    // var time = value.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [value];
    //
    // if (time.length > 1) { // If time format correct
    //     time = time.slice(1); // Remove full string match value
    //     time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
    //     time[0] = +time[0] % 12 || 12; // Adjust hours
    // }
    // return time.join(''); // return adjusted time or original string

    var timeString = value;
    var H = +timeString.substr(0, 2);
    var h = (H % 12) || 12;
    var ampm = H < 12 ? " AM" : " PM";
    timeString = h + timeString.substr(2, 3) + ampm;
    return timeString;
});

const app = new Vue({
    el: '#app',
});

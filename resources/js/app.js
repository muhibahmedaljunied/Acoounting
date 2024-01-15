require('./bootstrap');
require('./operation');
require('./staff/operation');
require('./contextmenu.js');
window.Vue = require('vue');			//import vue same as(import Vue from 'vue')

import VueRouter from 'vue-router';		//import vue router
import VueAxios from 'vue-axios';
import axios from 'axios';
// ---------------------------- sweetalert ---------------------------------------------------------
import swal from 'sweetalert2'

window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-center',
  showConfirmButton: false,
  timer: 3000
});
window.toast = toast;
// -----------------------------------This for alert messages ----------------------------------------------

window.toastMessage = function (title = null, text = null, icon = 'success') {


  return toast.fire({
    title: title,
    text: text,
    button: "Close", // Text on button
    icon: icon, //built in icons: success, warning, error, info
    timer: 3000, //timeOut for auto-close
    buttons: {
      confirm: {
        text: "OK",
        value: true,
        visible: true,
        className: "",
        closeModal: true,
      },
      cancel: {
        text: "Cancel",
        value: false,
        visible: true,
        className: "",
        closeModal: true,
      },
    },
  });


}

Vue.use(VueAxios, axios);
Vue.use(VueRouter);
// ---------------------------------------------------------------------------------------
import Vuex from 'vuex'					//import vuex
Vue.use(Vuex)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: '#007bff',
  failedColor: 'red',
  thickness: '7px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
})

import storeData from './store/store.js'
const store = new Vuex.Store(
  storeData
)

Vue.component('footer-section', require('./components/admin/layouts/Footer.vue').default);
Vue.component('main-header', require('./components/admin/layouts/MainHeader.vue').default);
Vue.component('main-sidebar', require('./components/admin/layouts/MainSidebar.vue').default);
Vue.component('page-header', require('./components/admin/layouts/PageHeader.vue').default);
Vue.component('sidebar-section', require('./components/admin/layouts/Sidebar.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);


//all vue routes from routes.js file
import routes from './routes.js';


// ---------------------------------this for printing---------------------------------------
import VueHtmlToPaper from 'vue-html-to-paper';
const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css'
  ]
}

Vue.use(VueHtmlToPaper, options);
// or, using the defaults with no stylesheet
Vue.use(VueHtmlToPaper);

// ------------------------------------------------------------------------

//router instance and pass the `routes` option
const router = new VueRouter({
  routes,
  mode: 'history',
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  }
})

//vue instance
const app = new Vue({
  el: '#app',
  data: {
    logo: 'Dashboard'
  },
  router,
  store,


});






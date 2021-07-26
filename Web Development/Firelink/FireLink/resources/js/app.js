
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Filetypes from './components/filetypes.vue';
import Search from './components/search.vue';
import Message from './components/messages.vue';
window.Vue.use(VueRouter);

let routes = [
    { path: '/filetypes', component: Filetypes },
    { path: '/search', component: Search },
    { path: '/messages', component: Message }
  ]
  
const router = new VueRouter({
    routes // short for `routes: routes`
  })

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('home-component', require('./components/home.vue').default);
Vue.component('file-type', require('./components/fileCmpo.vue').default);
Vue.component('access-control', require('./components/access.vue').default);
Vue.component('pagination', require('./components/paginate.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    methods: {
      fetchPosts() {
          axios.get('posts?page=' + this.pagination.current_page)
              .then(response => {
                  this.posts = response.data.data.data;
                  this.pagination = response.data.pagination;
              })
              .catch(error => {
                  console.log(error.response.data);
              });
      }
  },
    hashtag:false
});
router.mode = 'html5'
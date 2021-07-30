// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
let path = require('path');

import Vue from 'vue'
import App from './App.vue';
import "bootstrap";
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';

import Header from './components/Header.vue';
import Skills from './components/Skills.vue';
import Contact from './components/Contact.vue';
import Achievments from './components/Achievments.vue';
function isInViewport(element) {
    var rect = element.getBoundingClientRect();
    var html = document.documentElement;
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || html.clientHeight) &&
        rect.right <= (window.innerWidth || html.clientWidth)
    );
}

window.header = new Vue({
      el:'#app',
      render:h=>h(Header)
  })
var skillsRendered = false;
var achievmentsRendered = false;
var contactRendered = false;
window.onload = function() {
  document.body.style.overflowX = "hidden";
  window.onscroll = function() {
      if((window.scrollY > 17 && !skillsRendered) || (window.scrollY > 1 && window.innerHeight < 575 && !skillsRendered)) {
        window.Skills = new Vue({
          el:'#app2',
          render:h=>h(Skills)
        })
        skillsRendered = true;
      }
      else if(window.scrollY > 740 && !achievmentsRendered) {
        window.achievements = new Vue({
          el:'#app3',
          render:h=>h(Achievments)
        })
        achievmentsRendered = true;
      }
      else if(window.scrollY > 1660 && !contactRendered) {
        window.contact = new Vue({
          el:'#app4',
          render:h=>h(Contact)
        })
        contactRendered = true;
      }
    }
}

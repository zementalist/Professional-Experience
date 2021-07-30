<template>

  <div id="app">


  </div>
</template>

<script defer>
import Vue from 'vue';
import jQuery from "jquery";
import {TimelineLite} from "gsap/TweenMax";
import "../dist/scripts/split.js";
import VueFontAwesomeCss from 'vue-fontawesome-css';
import "animate.css";
import Wow from "Wow.js";

Vue.use(VueFontAwesomeCss)
export default {
  name:'App'
}
    var dropping = new TimelineLite();
    var once = true;
    var opened = false;
    var openCover = function() {
    var coverR = document.getElementsByClassName('opening-cover-left')[0];
    var coverL = document.getElementsByClassName('opening-cover-right')[0];
    var blackH = document.getElementById('blackH');
    var whiteH = document.getElementById('whiteH');
    var arrow = document.getElementById('arrowDown');

    var tl = new TimelineLite();
    let t =new Wow();
    t.init();

    var motionDown = new TimelineLite({onComplete:function() {
      this.restart()}
    });

    var textAnim = new TimelineLite({onComplete:function() {
      this.restart()}
    });
    //window.lazySizesConfig = window.lazySizesConfig || {}; window.lazySizesConfig.init = false;

    //Animating Intro
    var transSpeed = (window.innerWidth > 521 ? 5000 : 3000);
    textAnim.to([blackH,whiteH], 0.85, {'top':'48%'}).to([blackH,whiteH], 0.85, {'top':'50%'})
    tl.to(coverR, 0, {'width':'0vw', 'transition':String(transSpeed / 1000) + 's'}, '+=3');
    setTimeout(function() {
      textAnim.pause();
    }, 3000);
    tl.to(coverL, 0, {'margin-left':'100vw', 'transition':String(transSpeed / 1000) + 's'});
    tl.to(whiteH, 0, {'margin-left':'0rem', 'transition':'1s'});
    tl.to(document.documentElement, 0, {'overflow-y':'scroll'},'+=3');
    motionDown.to(arrow, 1, {'top':'105vh'}).to(arrow, 1, {'top':'100vh'});
    setTimeout(function() {
      tl.to([coverR, coverL, whiteH, blackH], 0, {'display':'none'});
      coverR.parentNode.removeChild(coverR);
      coverL.parentNode.removeChild(coverL);
    }, transSpeed + 3000);
  }
  // end animating Intro
  jQuery(document).ready(function(){
   // lazysizes.init();
    var headerBox = document.getElementById('headerBar');
    var homeImage = document.getElementsByClassName('lazyload')[0];
    var headItem = document.querySelectorAll('.headItem:not(.active):not(.logo):not(.logo-mob)');
    var imageSection = document.getElementById('imageSection');
    var logos = [document.getElementsByClassName('logo')[0], document.getElementsByClassName('logo-mob')[0]];
    var active = document.getElementsByClassName('active')[0];
    var mobileMenu = document.getElementsByClassName('mobileMenu')[0];
    let background = document.getElementsByClassName("background")[0];
    let text = document.getElementById("text");
    // setting up theme
    let themeIndex = Math.floor(Math.random() * 5) + 1;
    let textTheme = [
      {logoColor:"#4CE6FE", activeColor:"#f939ee", textColor:"#39acbe", textShadow:"1px 1px 0 #4da2fc, -1px -1px 0 #4da2fc, 1px -1px 0 #4da2fc, -1px 1px 0 #4da2fc, 4px 4px 8px #2c5889, -4px 4px 8px #2c5889, 4px -4px 8px #2c5889, -4px -4px 8px #2c5889"},
      {loglColor:"rgb(120, 255, 0)", activeColor:"rgb(255, 229, 0)", textColor:"#333333", textShadow:"1px 1px 0 #ffffff, -1px -1px 0 #ffffff, 1px -1px 0 #ffffff, -1px 1px 0 #fdfdfd, 4px 4px 8px #ffffff, -4px 4px 8px #ffffff, 4px -4px 8px #ffffff, -4px -4px 8px #ffffff"},
      {logoColor:"rgb(53, 0, 255)", activeColor:"rgb(255, 0, 0)", textColor:"#ffffff", textShadow:"0px 1px 0 #000000, -1px -1px 0 #000000, 1px -1px 0 #000000, -1px 1px 0 #000000, 4px 4px 8px #ffffff, -4px 4px 8px #ffffff, 4px -4px 8px #f1f1f1, -4px -4px 8px #ffffff"},
      {logoColor:"rgb(225, 255, 138)", activeColor:"rgb(57, 194, 249)", textColor:"#444646", textShadow:"1px 1px 0 #7c848c, -1px -1px 0 #ffffff, 1px -1px 0 #97999a, -1px 1px 0 #ffffff, 4px 4px 8px #94a1af, -4px 4px 8px #ffffff, 4px -4px 8px #ffffff, -4px -4px 8px #000000"},
      {logoColor:"#ffa700", activeColor:"rgb(237, 255, 1)", textColor:"#ff9207", textShadow:"1px 1px 0 #ffd507, -1px -1px 0 #ffffff, 1px -1px 0 #ffffff, -1px 1px 0 #6bfb09, 4px 4px 8px #ffd507, -4px 4px 8px #ffbc0a, 4px -4px 8px #ffa200, -4px -4px 8px #FF9800"}
    ];
    let themeExtension = (themeIndex == 3 ? '.png' : '.jpg');
    let themePath='../img1/bg/' + themeIndex + themeExtension;
    let optimizedPath = '../img1/bg-optimized/' + themeIndex + themeExtension;
    let currentLogoIndex = logos[0] ? 0 : 1; // 0 | 1  =  desktop | mobile

    background.setAttribute("src", optimizedPath);
    background.setAttribute("data-src", themePath);
    background.classList.add("lazyload");
    text.style.color = textTheme[themeIndex-1].textColor;
    text.style.textShadow = textTheme[themeIndex-1].textShadow;

    logos[currentLogoIndex].style.color = textTheme[themeIndex-1].logoColor;
    active.style.color = textTheme[themeIndex-1].activeColor;
    // end - setting up theme

    var colorChanged = false;
    var el = jQuery('.background');
    var el2 = jQuery('.background-infrastructure');
    jQuery(window).on('scroll', function () {
      
        var scroll = jQuery(document).scrollTop();
        el.css({
            'height':window.innerHeight+(-.4*scroll)+'px'
        });
        el2.css({
            'height':window.innerHeight+(-.4*scroll)+'px'
        });
    });
    function dropDown() {
      if(((window.scrollY > 410 && window.innerWidth > 521) || (window.scrollY > 385 && window.innerWidth <= 521)) && !colorChanged) {
        headerBox.style.boxShadow = '0px 0px 10px 0px #222';
        colorChanged = !colorChanged;
      }
      else if(((window.scrollY <= 410 && window.innerWidth > 521) && colorChanged)) {
        headerBox.style.boxShadow = '0px 0px 10px 0px #fff';
        colorChanged = !colorChanged;
      }
      else if(window.scrollY > 116 && once && window.innerWidth > 521) {
        dropping.to(headerBox, 1, {'height':'5.5rem'});
        dropping.to(headItem, 0.5, {'color':'black'}, '-=1');
        //dropping.to(logos, 0.5, {'color':textTheme[themeIndex-1].logoColor}, '-=1');
        dropping.to(active, 0.5, {'color':textTheme[themeIndex-1].activeColor}, '-=1');
        once = false;
      }
      else if (window.scrollY < 116 && !once && window.innerWidth > 521) {
        dropping.to(headerBox, 1, {'height':'0%'});
        dropping.to(headItem, 0.5, {'color':'white'}, '-=1');
       // dropping.to(logos, 0.5, {'color':textTheme[themeIndex-1].logoColor}, '-=1');
        dropping.to(active, 0.5, {'color':textTheme[themeIndex-1].activeColor}, '-=1');
        once = true;
      }
    }
    function handleNavbar() {
      if(window.innerWidth > 521) {
        ;
      }
      else {
        document.getElementsByClassName('menu')[0].addEventListener('click', dropMenu);
      }
    }


    function dropMenu() {
      if(!opened) {
        dropping.to(headerBox, 1, {'height':'19rem'});
        dropping.to(mobileMenu, 1, {'opacity':'1','display':'block'}, '-=1');
        opened = !opened;
      }
      else {
        dropping.to(headerBox, 1, {'height':'4.5rem'});
        dropping.to(mobileMenu, 1, {'opacity':'0','display':'none'}, '-=1');
        opened = !opened;
      }
    }
    var sectionLoaded = false;

    function setActiveByIndex(index) {
      var className = window.innerWidth > 521 ? "headItem" : "mobileItem";
      for(var i = 0; i <= 4; i++) {
        var j = className == "headItem" ? i : (i-1);
        if(i != index && (j >= 0)) {
          if(className == 'headItem' && i == 0) {
            continue;
          }
          document.getElementsByClassName(className)[j].setAttribute('class',className);
          document.getElementsByClassName(className)[j].style.color = "black";
        }
      }
      index = className == "headItem" ? index : (index-1);
      document.getElementsByClassName(className)[index].setAttribute('class', className + " active");
      active = document.getElementsByClassName('active')[0];
      active.style.color = textTheme[themeIndex-1].activeColor;
    }

    function sectionVisited() {
      if(window.innerWidth > 521) { // if pc view //
        if(window.scrollY < parseInt(jQuery("#imageSection").height()) - parseInt(jQuery("#headerBar").height())) {
          document.getElementsByClassName('headItem')[2].setAttribute('class','headItem');
          var color = document.getElementsByClassName('headItem')[2].style.color;
          document.getElementsByClassName('headItem')[3].style.color = color;
          document.getElementsByClassName('headItem')[4].style.color = color;
          document.getElementsByClassName('headItem')[1].setAttribute('class','headItem active');
          active = document.getElementsByClassName('active')[0];
          active.style.color = textTheme[themeIndex-1].activeColor;
        }
        if(window.scrollY > parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height())  && window.scrollY <  parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) && window.scrollY < (parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) + parseInt(jQuery("#achievmentsSection").height()) + 500 )) {
          setActiveByIndex(2);
          sectionLoaded = true;
        }
        /*else if(window.scrollY >= 1400 && window.scrollY < 3400) {
          setActiveByIndex(3)
        }*/
        else if (window.scrollY >  parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) && window.scrollY < (parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) + parseInt(jQuery("#achievmentsSection").height()) + 500 )) {
          setActiveByIndex(3);
        }
        else if (window.scrollY > parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) + parseInt(jQuery("#achievmentsSection").height()) + 500 ) {
            setActiveByIndex(4);
        }
        else {
          //Nothing needed until this moment;
        }
      }
      else {
        if(window.scrollY < parseInt(jQuery("#imageSection").height()) - parseInt(jQuery("#headerBar").height())) {
          setActiveByIndex(1);
        }
        if(window.scrollY > parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height())  && window.scrollY <  parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) && window.scrollY < (parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) + parseInt(jQuery("#achievmentsSection").height()) + 500 )) {
          setActiveByIndex(2);
          sectionLoaded = true;
        }
        /*else if(window.scrollY >= 1400 && window.scrollY < 3400) {
          setActiveByIndex(3)
        }*/
        else if (window.scrollY >  parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) && window.scrollY < (parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) + parseInt(jQuery("#achievmentsSection").height()))) {
          setActiveByIndex(3);
        }
        else if (window.scrollY > parseInt(jQuery("#skillsSection").height()) + parseInt(jQuery("#imageSection").height()) + parseInt(jQuery("#headerBar").height()) + parseInt(jQuery("#achievmentsSection").height())) {
            setActiveByIndex(4);
        }
        else {
          //Nothing needed until this moment;
        }
      }
    }
    var inv;
    var speed = 0.01;
    function goto(prevSectionID) {
      var limit;
      if(prevSectionID == "#imageSection") {
        if(window.innerWidth > 521) {
          limit = '640rem';
        }
        else {
          limit = '1100rem';
        }
      }
      else if(prevSectionID == "#skillsSection") {
        if(window.innerWidth >= 871 && window.innerWidth > 816) {
          limit = '1450vh';
        }
        else if(window.innerWidth <= 816 && window.innerWidth >= 768) {
          limit = '2030vh';
        }
        else if(window.innerWidth < 768 && window.innerWidth > 575) {
          limit = '2000vh';
        }
        else if (window.innerWidth <= 575 && window.innerWidth > 521) {
          limit = '1950vh';
        }
        else {
          limit = '1750rem';
        }
      }
      else if(prevSectionID == "#achievmentsSection") {
        if(window.innerWidth >= 871 && window.innerWidth > 816) {
          limit = '2550vh';
        }
        else if(window.innerWidth <= 816 && window.innerWidth >= 768) {
          limit = '3230vh';
        }
        else if(window.innerWidth < 768 && window.innerWidth > 575) {
          limit = '3600vh';
        }
        else if (window.innerWidth <= 575 && window.innerWidth > 521) {
          limit = '4900vh';
        }
        else {
          limit = '4520rem';
        }
      }
      else if(prevSectionID == "#none") {
        limit = 0;
      }
      jQuery("html, body").animate({ scrollTop: limit }, 1700);
      return limit;
    }
    function eventsCreator() {
      var headItems = document.getElementsByClassName('headItem');
      if(window.innerWidth > 521 || headItems.length > 0) {
        var home = headItems[1];
        var skills = headItems[2];
        var achievments = headItems[3];
        var contact = headItems[4];
        home.addEventListener('click', function(){goto('#none')});
        skills.addEventListener('click', function(){goto("#imageSection")});
        achievments.addEventListener('click', function(){goto("#skillsSection")});
        contact.addEventListener('click', function(){goto("#achievmentsSection")});
      }
      else {
        var mobileItems = document.getElementsByClassName('mobileItem');
        var home = mobileItems[0];
        var skills = mobileItems[1];
        var achievments = mobileItems[2];
        var contact = mobileItems[3];
        home.addEventListener('click', function(){goto('#none');dropMenu()});
        skills.addEventListener('click', function(){goto("#imageSection");dropMenu()});
        achievments.addEventListener('click', function(){goto("#skillsSection");dropMenu()});
        contact.addEventListener('click', function(){goto("#achievmentsSection");dropMenu()});
      }
    }
    eventsCreator();
    openCover();
    handleNavbar();
    
    function randomIntFromInterval(min,max)
  {
    return Math.floor(Math.random()*(max-min+1)+min);
  }
  var sentences = ['Zeyad Khalid', 'Full Stack Web Developer', 'Front-End Developer', 'Back-End Developer'];

function typewrite(elmId, text, speed, ratio) {
    var element = document.getElementById(elmId);
    element.innerHTML = "";
    element.style.display = 'block';
    element.innerHTML = text;
    var mySplitTextTyper = new SplitText(element, {type:"words"});
    var splitTextTimelineTyper = new TimelineLite();
    TweenLite.set(element, {perspective:400});
    splitTextTimelineTyper.clear().time(0);
    mySplitTextTyper.revert();
    mySplitTextTyper.split({type:"chars, words"});
    splitTextTimelineTyper.staggerFrom(mySplitTextTyper.chars, speed, {scale:4, autoAlpha:0,  rotationX:-180,  transformOrigin:"100% 50%", ease:Back.easeOut}, ratio).eventCallback('onComplete', function(){this.reverse();})
  }

  var loop = setInterval(typeRouter, 4000, sentences);
  function typeRouter(collection) {
    clearInterval(loop);
    var randTxt = collection[Math.floor(Math.random() * collection.length)];
    var speed = 2;
    var ratio = 0.1;
    var timeToFinish = (speed * ratio) * randTxt.length * 2 * 1000;
    typewrite('text',randTxt,speed, ratio);
    loop = setInterval(typeRouter,timeToFinish + 1200, sentences);
  }


  window.addEventListener('scroll',function() {
    dropDown();
    sectionVisited();
  })
  window.addEventListener('resize',function() {
    dropDown();
    handleNavbar();
  })
})
// Header Scripts END //

</script>

<style lang="css">
import d
html,body {
  overflow-x: hidden !important;
  margin: 0;
  padding: 0;
  scroll-behavior: smooth;
}
.row {
  margin-left: 0px;
}
.col-md-12 {
  padding-right: 0px;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
* {
  font-display: swap;
}
</style>
